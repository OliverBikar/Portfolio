package GUIVersion;

/**
 *
 * @author 16072277
 */
public class Controller {
    private Model model; //Used to update the controller if data changes.
    private View view; //Used to visualise data stored in the model.
    /*Store the position of the selected square*/
    private int characterIndex, numberIndex;
    
    public Controller(Model model) {
        this.model = model;
    }
    
    /**
     * Sets the view for the controller object.
     * 
     * @param view contains a view object.
     */
    public void setView(View view) {
        this.view = view;
    }
    
    /**
     *
     * @return the number of shots required to destroy the entire fleet.
     */
    public int getRequiredShots() {
        return model.getRequiredNumAttempts();
    }
    
    /**
     * Displays a window that instructs the user about how to play the game.
     */
    public void displayInstructionsAlert() {
        view.instructionsAlert();
    }
    
    /**
     * Disable the play and instruction button and trigger mouse clicking event
     * to the grid.
     */
    public void playGame() {
        view.isPlayButtonDisabled(true);
        view.isInstructionButtonDisabled(true);
        view.enableGridMouseClick();
    }
    
    /**
     *
     * @return the character index of the selected square.
     */
    public int getCharacterIndex() {
        return characterIndex;
    }
    
    /**
     *
     * @return the number index of the selected square.
     */
    public int getNumberIndex() {
        return numberIndex;
    }
    
    /**
     * Changes the colour of the selected square to red if a ship has been hit
     * or white if the player has missed.
     * 
     * @param characterIndex an integer in the range 1-10.
     * @param numberIndex an integer in the range 1-10.
     */
    public void launchAttack(int characterIndex, int numberIndex) {
        this.characterIndex = characterIndex;
        this.numberIndex = numberIndex;
        
        view.setTileColour(getCharacterIndex(), getNumberIndex());
    }
    
    /**
     * Once all ships have sunk, display an alert window confirming that the 
     * whole fleet has sunk along with the number of shots required.
     */
    public void gameOver() {
        if(!model.isGameOver()) {
            view.scoreboardAlert();
        }
    }
    
    /**
     * Closes the game.
     */
    public void exitGame() {
        System.exit(0);
    }
}
