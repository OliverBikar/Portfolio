package GUIVersion;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.util.Observable;
import java.util.Observer;
import javafx.application.Application;
import javafx.event.ActionEvent;
import javafx.event.EventHandler;
import javafx.geometry.HPos;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.control.Button;
import javafx.scene.control.DialogEvent;
import javafx.scene.control.Label;
import javafx.scene.input.MouseEvent;
import javafx.scene.layout.GridPane;
import javafx.scene.layout.StackPane;
import javafx.scene.paint.Color;
import javafx.scene.shape.Rectangle;
import javafx.stage.Stage;

/**
 *
 * @author 16072277
 */
public class View extends Application implements Observer {
    /*Store the play button and instruction button*/
    private final Button playButton = new Button("Play Game");
    private final Button instructionButton = new Button("Instructions");
    
    /*Store an alert window to confirm that a ship has sunk*/
    private final Alert sunkShipAlert = new Alert(AlertType.INFORMATION);
    
    /*Store an alert window to confirm that the game has ended*/
    private final Alert scoreboardAlert = new Alert(AlertType.INFORMATION);
    
    /*Store the dimensions of the window*/
    private static final int WINDOW_WIDTH = 370;
    private static final int WINDOW_HEIGHT = 290;
    
    /*Store the dimensions of the grid and the grid that the user sees*/
    private static final int SIZE = 11;
    private Rectangle[][] grid = new Rectangle[SIZE][SIZE];
    
    /*Store visual components that are inserted into multiple rows and columns*/
    private GridPane gridPane = new GridPane();
    
    /*An object storing data. It can update the controller if data changes*/
    private Model model;
    
    /*Controls the data flow of a model object and update the view if the data
      changes. It keeps the model and view seperate.*/
    private Controller controller;
    
    public static void main(String[] args) {
        launch(args);
    }

    /**
     * Creates and lays out the grid on the window that the user sees when
     * playing the game.
     */
    public void drawGrid() {
        char letterCounter = 'A';
        Label characterLabel, numberLabel;
        
        for (int row = 0; row < SIZE; row++) {
            for (int column = 0; column < SIZE; column++) {
                grid[row][column] = new Rectangle(25,25);
                grid[row][column].setStroke(Color.BLACK);
                grid[row][column].setFill(Color.LIGHTGRAY);
                gridPane.add(grid[row][column], row, column);
            }
        }
        
        for (int index = 0; index < SIZE; index++) {
            grid[index][0].setDisable(true);
            grid[0][index].setDisable(true);
            grid[index][0].setVisible(false);
            grid[0][index].setVisible(false);
        }
        
        for (int index = 1; index < SIZE; index++) {
            characterLabel = new Label(String.valueOf(letterCounter++));
            numberLabel = new Label(String.valueOf(index));
            
            GridPane.setHalignment(characterLabel, HPos.CENTER);
            GridPane.setHalignment(numberLabel, HPos.CENTER);
            gridPane.add(characterLabel, index, 0);
            gridPane.add(numberLabel, 0, index);
        }
    }
    
    /**
     * Displays an alert window that explains the rules of the game.
     */
    public void instructionsAlert() {
        Alert instructionsAlert = new Alert(Alert.AlertType.INFORMATION);
        
        try {
            File file = new File("instructions.txt");
            BufferedReader analyser = new BufferedReader(new FileReader(file));
            String line;
            
            while((line = analyser.readLine()) != null) {
                String[] gameTutorial = line.split(",");
                instructionsAlert.setTitle("Battleships");
                instructionsAlert.setHeaderText("How To Play");
                
                instructionsAlert.setContentText(
                    gameTutorial[0] + " " + 
                    gameTutorial[1] + " " + 
                    gameTutorial[2] + "\n\n" + 
                    gameTutorial[3] + "\n" + 
                    gameTutorial[4]
                );
            }
            
            analyser.close();
            instructionsAlert.show();
        }catch(Exception e) {
            e.printStackTrace();
        }
    }
    
    /**
     * Reports the number of shots required to destroy the entire fleet.
     */
    public void scoreboardAlert() {
        try {
            File file = new File("scoreboard.txt");
            BufferedReader analyser = new BufferedReader(new FileReader(file));
            String line;
            
            while((line = analyser.readLine()) != null) {
                String[] scoreboardInfo = line.split(",");
                scoreboardAlert.setTitle("Battleships");
                scoreboardAlert.setHeaderText(scoreboardInfo[0]);
                
                scoreboardAlert.setContentText(
                    scoreboardInfo[1] + "\n" + 
                    scoreboardInfo[2] + " " + 
                    controller.getRequiredShots()
                );
            }
            
            analyser.close();
            scoreboardAlert.show();
        }catch(Exception e) {
            e.printStackTrace();
        }
    }
    
    /**
     *
     * @param row an integer in the range 1-10.
     * @param column an integer in the range 1-10.
     * @return a different colour tile in the selected location. Also, an alert 
     *  window confirming that the game is over iff all ships have sunk.
     */
    public EventHandler<? super MouseEvent> getTarget(int row, int column) {
        return event -> controller.launchAttack(row, column);
    }
    
    /**
     * Lays out the components i.e. the grid, play button and instruction button 
     * on the window that the user sees when playing the game.
     * 
     * @return the content inserted into the grid pane.
     */
    public GridPane initialiseGridPane() {
        GridPane.setHalignment(playButton, HPos.RIGHT);
        GridPane.setHalignment(instructionButton, HPos.RIGHT);
        
        drawGrid();
        gridPane.add(playButton, 12, 1);
        gridPane.add(instructionButton, 12, 2);
        
        /*
          If the play button is clicked, disable the play button and instruction
          button and enable the player's click on the grid to be processed.
        */
        playButton.setOnAction(new EventHandler<ActionEvent>() {
            @Override
            public void handle(ActionEvent event) {
                controller.playGame();
            }
        });
        
        /*
          If the instruction button is clicked, the controller displays an alert 
          window which shows the instructions of the game.
        */
        instructionButton.setOnAction(new EventHandler<ActionEvent>() {
            @Override
            public void handle(ActionEvent event) {
                controller.displayInstructionsAlert();
            }
        });
        
        /*
          Once the alert window closes, the controller checks if all ships have 
          sunk. If the condition is true, display an alert window to confirm 
          that the player has sunk the whole fleet.
        */
        sunkShipAlert.setOnCloseRequest(new EventHandler<DialogEvent>() {
            @Override
            public void handle(DialogEvent event) {
                controller.gameOver();
            }
        });
        
        /*
          The controller closes the game if the alert window called 
          scoreboardAlert is closed.
        */
        scoreboardAlert.setOnCloseRequest(new EventHandler<DialogEvent>() {
            @Override
            public void handle(DialogEvent event) {
                controller.exitGame();
            }
        });
        
        return gridPane;
    }
    
    @Override
    public void start(Stage primaryStage) {
        model = new Model();
        controller = new Controller(model);
        controller.setView(this);
        
        gridPane = initialiseGridPane();
        
        StackPane root = new StackPane();
        root.getChildren().add(gridPane);
        
        Scene scene = new Scene(root, WINDOW_WIDTH, WINDOW_HEIGHT);
        
        primaryStage.setTitle("Battleships");
        primaryStage.setScene(scene);
        primaryStage.setResizable(false);
        primaryStage.show();
        
        model.addObserver(this);
        update(null, null);
    }
    
    @Override
    public void update(Observable o, Object arg) {
        Ship[][] board = model.getGrid();
        int numberIndex = controller.getNumberIndex();
        int characterIndex = controller.getCharacterIndex();
        Ship ship = board[numberIndex][characterIndex];
        
        sunkShipAlert.setTitle("Battleships");
        sunkShipAlert.setHeaderText("Notification");
        sunkShipAlert.setContentText("You have sunk a " + ship.getType());
        
        if(model.isOccupied(numberIndex, characterIndex) && ship.isSunk()) {
            sunkShipAlert.show();
        }
    }
    
    /**
     * Activates mouse clicking event. When the player clicks a square on the
     * grid, the position is obtained and used to launch an attack.
     */
    public void enableGridMouseClick() {
        for (int row = 0; row < grid.length; row++) {
            for (int column = 0; column < grid.length; column++) {
                grid[row][column].setOnMouseClicked(getTarget(row, column));
            }
        }
    }
    
    /**
     * If the player has hit the ship, change the colour of the selected square 
     * to red and disable it. Otherwise, change the colour of it to white and
     * disable it.
     * 
     * @param characterIndex an integer in the range 1-10.
     * @param numberIndex an integer in the range 1-10.
     */
    public void setTileColour(int characterIndex, int numberIndex) {
        if(model.attackShip(numberIndex, characterIndex)) {
            grid[characterIndex][numberIndex].setDisable(true);
            grid[characterIndex][numberIndex].setStroke(Color.BLACK);
            grid[characterIndex][numberIndex].setFill(Color.RED);
        }
        
        else {
            grid[characterIndex][numberIndex].setDisable(true);
            grid[characterIndex][numberIndex].setStroke(Color.BLACK);
            grid[characterIndex][numberIndex].setFill(Color.WHITE);
        }
    }
    
    /**
     * Disable the button titled Play Game iff disable equals true.
     * 
     * @param disable stores the value true or false.
     */
    public void isPlayButtonDisabled(boolean disable) {
        playButton.setDisable(disable);
    }
    
    /**
     * Disable the button titled Instructions iff disable equals true.
     * 
     * @param disable stores the value true or false.
     */
    public void isInstructionButtonDisabled(boolean disable) {
        instructionButton.setDisable(disable);
    }
    
}
