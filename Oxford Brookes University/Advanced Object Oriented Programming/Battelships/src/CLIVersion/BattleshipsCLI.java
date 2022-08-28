package CLIVersion;

import java.util.ArrayList;
import java.util.Scanner;
import java.util.regex.Pattern;

/**
 *
 * @author 16072277
 */
public class BattleshipsCLI {

    public static void main(String[] args) {
        Model model = new Model();
        String[][] grid = new String[11][11];
        Scanner inputReader = new Scanner(System.in);
        
        displayGrid(grid);
        System.out.println("Welcome to Battleships!");
        
        while(model.isGameOver()) {
            System.out.println("Enter a grid position e.g. A1:");
            launchAttack(validateAlphanumericInput(inputReader), grid, model);
            displayGrid(grid);
        }
        
        System.out.println("You have sunk the whole fleet!");
        System.out.println("Attempts Needed: " + model.getRequiredNumAttempts());
    }
    
    /**
     * Makes alphanumericList store the values A1-A10, B1-B10 etc. upto J10.
     * 
     * @return a set of alphanumeric values i.e. alphanumericList.
     */
    private static ArrayList<String> alphanumericList() {
        char[] characters = new char[11];
        int[] numbers = new int[11];
        ArrayList<String> alphanumericList = new ArrayList<String>();
        char character = 'A';
        
        for (int i = 1; i < characters.length; i++) {
            characters[i] = character++;
            numbers[i] = i;
        }
        
        for (int charIndex = 1; charIndex < characters.length; charIndex++) {
            for (int numIndex = 1; numIndex < numbers.length; numIndex++) {
                alphanumericList.add(getAlphanumericValue(characters[charIndex], numbers[numIndex]));
            }
        }
        
        return alphanumericList;
    }
    
    /**
     * 
     * @param character stores the character section of the alphanumeric value.
     * @param number stores the numeric section of the alphanumeric value.
     * @return an alphanumeric value.
     */
    private static String getAlphanumericValue(char character, int number) {
        return new StringBuilder().append(character).append(number).toString();
    }
    
    /**
     * Checks if a valid alphanumeric value has been entered. If the value is
     * invalid, an error message is displayed. The process repeats until the
     * input is valid.
     * 
     * @param attackInputScanner obtains the player's input.
     * @return the entered alphanumeric value.
     */
    private static String validateAlphanumericInput(Scanner attackInputScanner) {
        ArrayList<String> alphanumericList = alphanumericList();
        String input = "";
        boolean isValid = false;
        
        while(!isValid) {
            input = attackInputScanner.next();
            
            if(alphanumericList.contains(input)) {
                isValid = true;
            }
            
            else {
                System.err.println("Please try again");
            }
        }
        
        return input;
    }
    
    /**
     * Checks the given location to be attacked. If the location has not already
     * been targeted and the player hits empty sea, output a message stating
     * that they have missed. It outputs an error message if the given location
     * has already been targeted. Also, it informs the player when they have
     * sunk a ship.
     * 
     * @param input stores the given grid location to be attacked.
     * @param grid updates the given grid location by storing "H" or "M".
     * @param model used to check if the given location is occupied by a ship
     *  and whether or not it has already been attacked.
     */
    private static void launchAttack(String input, String[][] grid, Model model) {
        Pattern pattern = Pattern.compile("[^0-9]");
        int characterIndex = Character.toLowerCase(input.charAt(0)) - 'a' + 1;
        int numberIndex = Integer.parseInt(pattern.matcher(input).replaceAll(""));
        
        boolean isOccupied = model.isOccupied(numberIndex, characterIndex);
        boolean isShipAttacked = model.attackShip(numberIndex, characterIndex);
        boolean hasTargeted = hasAlreadyAttacked(model, numberIndex, characterIndex, grid);
        
        Ship[][] board = model.getGrid();
        Ship ship = board[numberIndex][characterIndex];
        
        if(!isShipAttacked && !hasTargeted) {
            grid[numberIndex][characterIndex] = "M";
            System.out.println("\nYou have missed\n");
        }
        
        if(hasTargeted) {
            System.err.println("You have already attacked this location");
        }
        
        while(isOccupied && isShipAttacked && !hasTargeted) {
            if(ship.isSunk()) {
                grid[numberIndex][characterIndex] = "H";
                System.out.println("\nYou have sunk a " + ship.getType() + "\n");
            }
            
            else {
                grid[numberIndex][characterIndex] = "H";
                System.out.println("\nYou have hit a " + ship.getType() + "\n");
            }
            
            hasTargeted = true;
        }
    }
    
    /**
     * 
     * @param model used to check if the given location has already been shot.
     * @param row an integer in the range 1-10.
     * @param column an integer in the range 1-10.
     * @param grid used to check if the given location contains "H" or "M".
     * @return true iff the player has already attacked a location that has hit or missed.
     */
    private static boolean hasAlreadyAttacked(Model model, int row, int column, String[][] grid) {
        boolean hasAlreadyHit = model.hasAlreadyShot(row, column) && grid[row][column].equals("H");
        boolean hasAlreadyMissed = model.hasAlreadyShot(row, column) && grid[row][column].equals("M");
        
        return hasAlreadyHit || hasAlreadyMissed;
    }
    
    /**
     * Prints a grid that updates as the user plays the game.
     * 
     * @param grid setup and display the grid.
     */
    private static void displayGrid(String[][] grid) {
        char letterCounter = 'A';
        grid[0][0] = "";
        
        for (int index = 1; index < grid.length; index++) {
            grid[0][index] = String.valueOf(letterCounter++);
            grid[index][0] = String.valueOf(index);
        }
        
        for (int row = 0; row < grid.length; row++) {
            for (int column = 0; column < grid.length; column++) {
                if(grid[row][column] == null) {
                    grid[row][column] = ".";
                }
            }
        }
        
        for (int row = 0; row < grid.length; row++) {
            for (int column = 0; column < grid.length; column++) {
                System.out.printf("%3s", grid[row][column]);
            }
            System.out.println(" ");
        }
        
        System.out.println();
    }
    
}
