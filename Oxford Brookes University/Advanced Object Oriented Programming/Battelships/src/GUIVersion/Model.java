package GUIVersion;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.util.Observable;

/**
 *
 * @author 16072277
 */
public class Model extends Observable {
    /*Store the dimensions of the grid.*/
    private static final int SIZE = 11;
    /*Store the guesses required to sink the whole fleet, the total
      number of ships on the grid and sank.*/
    private int requiredNumAttempts, shipTotal, sunkShipCounter;
    private Ship[][] grid = new Ship[SIZE][SIZE];
    /*Monitors the location that the player has already shot on the grid.*/
    private boolean[][] hasAlreadyShot = new boolean[SIZE][SIZE];
    
    public Model() {
        assert SIZE == 11 : "Grid dimension is invalid";
        
        for (int row = 0; row < SIZE; row++) {
            for (int column = 0; column < SIZE; column++) {
                grid[row][column] = new Ship(row, column);
                grid[row][column].setType("Empty Sea");
                hasAlreadyShot[row][column] = false;
            }
        }
        
        initialiseShips();
    }
    
    /**
     *
     * @return the number of attempts needed to sink the entire fleet.
     */
    public int getRequiredNumAttempts() {
        return requiredNumAttempts;
    }
    
    /**
     *
     * @return the actual grid.
     */
    public Ship[][] getGrid() {
        return grid;
    }
    
    /**
     *
     * @param row an integer in the range 1-10.
     * @param column an integer in the range 1-10.
     * @return true iff the player has already shot in a particular location.
     */
    public boolean hasAlreadyShot(int row, int column) {
        return hasAlreadyShot[row][column];
    }
    
    /**
     * Reads in the values from a .txt file that are used to create and place
     * five ships. One of length 5, one of length 4, one of length 3 and two of
     * length 2.
     */
    public void initialiseShips() {
        assert requiredNumAttempts == 0 && shipTotal == 0 : "No. of attempts to sink the whole fleet and total No. of ships must begin at zero";
        
        try {
            File file = new File("ships.txt");
            
            BufferedReader analyser = new BufferedReader(new FileReader(file));
            String line;
            
            while((line = analyser.readLine()) != null) {
                String[] shipInfo = line.split(",");
                String shipType = shipInfo[0];
                int row = Integer.parseInt(shipInfo[1]);
                int column = Integer.parseInt(shipInfo[2]);
                boolean isHorizontal = Boolean.parseBoolean(shipInfo[3]);
                
                if(row <= 1 || row >= 11 || column <= 1 || column >= 11) {
                    throw new AssertionError("Ship position is out of range");
                }
                
                else if(grid[row][column].isValidBoatPosition(this)) {
                    grid[row][column] = shipBuilder(shipType, row, column);
                    grid[row][column].isHorizontal(isHorizontal);
                    grid[row][column].insertShip(grid[row][column], this);
                    requiredNumAttempts += grid[row][column].getLength();
                    shipTotal++;
                }
                
                else {
                    throw new AssertionError("Ships are intersecting on the grid");
                }
            }
            
            analyser.close();
        }catch(Exception e) {
            System.err.println("File is not found");
        }
        
        assert requiredNumAttempts == 16 && shipTotal == 5 : "No. of attempts to sink the whole fleet must equal 16 and total No. of ships must equal 5";
    }
    
    /**
     * Creates a new ship object based on the value stored in the parameter
     * called type.
     * 
     * @param type indicates the type of ship to be created.
     * @param row an integer in the range 1-10.
     * @param column an integer in the range 1-10.
     * @return a new ship object of the desired type.
     */
    public Ship shipBuilder(String type, int row, int column) {
        Ship ship = new Ship(row, column);
        
        if(type.equals("Battleship")) {
            ship.setLength(4);
            ship.setType(type);
        }
        
        else if(type.equals("Carrier")) {
            ship.setLength(5);
            ship.setType(type);
        }
        
        else if(type.equals("Destroyer")) {
            ship.setLength(3);
            ship.setType(type);
        }
        
        else if(type.equals("Patrol Boat")) {
            ship.setLength(2);
            ship.setType(type);
        }
        
        else {
            throw new AssertionError("Invalid ship type");
        }
        
        return ship;
    }
    
    /**
     * Initiates the attack in the given location and updates the number of
     * ships sunk.
     * 
     * @param row an integer in the range 1-10.
     * @param column an integer in the range 1-10.
     * @return true iff the given location contains a ship that has not sunk.
     */
    public boolean attackShip(int row, int column) {
        if(hasAlreadyShot[row][column] == false) {
            hasAlreadyShot[row][column] = true;
            
            while(grid[row][column].recordHit(row, column)) {
                if(grid[row][column].isSunk()) {
                    sunkShipCounter++;
                    setChanged();
                    notifyObservers();
                }
                
                return true;
            }
        }
        
        return false;
    }
    
    /**
     *
     * @param row an integer in the range 1-10.
     * @param column an integer in the range 1-10.
     * @return true iff the targeted square is occupied by a ship.
     */
    public boolean isOccupied(int row, int column) {
        String shipType = grid[row][column].getType();
        return !shipType.equals("Empty Sea");
    }
    
    /**
     *
     * @return true until all ships are destroyed.
     */
    public boolean isGameOver() {
        return sunkShipCounter < shipTotal;
    }
}
