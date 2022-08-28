package GUIVersion;

/**
 *
 * @author 16072277
 */
public class Ship {
    /*Store the row, column, length and number of hits made to the ship.*/
    private int row, column, length, damageCounter;
    /*Store the name of the square.*/
    private String type;
    /*Store the orientation of the ship.*/
    private boolean isHorizontal;
    /*Monitors the locations of the ship that have been hit.*/
    private boolean[] isHit = new boolean[5];
    
    public Ship(int row, int column) {
        this.row = row;
        this.column = column;
    }
    
    /**
     *
     * @return the number of squares occupied by the ship.
     */
    public int getLength() {
        return length;
    }
    
    /**
     * Set the number of squares occupied by the ship.
     * 
     * @param length stores the desired value.
     */
    public void setLength(int length) {
        this.length = length;
    }
    
    /**
     *
     * @return the name of the square.
     */
    public String getType() {
        return type;
    }
    
    /**
     * Set the name of the square.
     * 
     * @param type stores the desired name.
     */
    public void setType(String type) {
        this.type = type;
    }
    
    /**
     * Sets the ship's orientation as horizontal (true) or vertical (false).
     * 
     * @param isHorizontal stores the value true or false.
     */
    public void isHorizontal(boolean isHorizontal) {
        this.isHorizontal = isHorizontal;
    }
    
    /**
     *
     * @return the number of hits made to the ship.
     */
    public int getDamageCounter() {
        return damageCounter;
    }
    
    /**
     * Places the ship onto the grid according to it's orientation.
     * 
     * @param ship is the ship that is being placed onto the grid.
     * @param model is used to obtain the grid.
     */
    public void insertShip(Ship ship, Model model) {
        Ship[][] grid = model.getGrid();
        
        if(isHorizontal) {
            for(int col = column; col < column + getLength(); col++) {
                grid[row][col] = this;
            }
        }
        
        else {
            for (int sRow = row; sRow < row + getLength(); sRow++) {
                grid[sRow][column] = this;
            }
        }
    }
    
    /**
     * Ensures that it is legal to insert a ship of a particular length and
     * orientation in a given location. It prevents intersection among ships.
     * 
     * @param model used to examine the vacancy of a square on the grid.
     * @return true iff it is legal to insert a ship in a given location.
     */
    public boolean isValidBoatPosition(Model model) {
        if(isHorizontal) {
            for (int col = column - 1; col <= column + getLength(); col++) {
                if(model.isOccupied(row - 1, col) || model.isOccupied(row, col) || model.isOccupied(row + 1, col)) {
                    return false;
                }
            }
        }
        
        else {
            for (int sRow = row - 1; sRow <= row + getLength(); sRow++) {
                if(model.isOccupied(sRow, column - 1) || model.isOccupied(sRow, column) || model.isOccupied(sRow, column + 1)) {
                    return false;
                }
            }
        }
        
        return true;
    }
    
    /**
     * Checks if a ship that has not sunk occupies the given row and column.
     * In the isHit array, zero indicates the bow.
     * 
     * @param shipRow an integer in the range 1-10.
     * @param shipColumn an integer in the range 1-10.
     * @return true iff the ship occupies the targeted square of the grid.
     */
    public boolean recordHit(int shipRow, int shipColumn) {
        while(!this.isSunk()) {
            if(isHorizontal) {
                isHit[shipColumn - column] = true;
            }
            
            else {
                isHit[shipRow - row] = true;
            }
            
            damageCounter++;
            return true;
        }
        
        return false;
    }
    
    /**
     *
     * @return true iff the number of hits made to the ship equals its length.
     */
    public boolean isSunk() {
        return getDamageCounter() == getLength();
    }
}
