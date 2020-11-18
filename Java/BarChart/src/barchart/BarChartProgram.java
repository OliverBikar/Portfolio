/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package barchart;

import javafx.application.Application;
import javafx.event.EventHandler;
import javafx.scene.input.MouseEvent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.CheckBox;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;
import javafx.scene.layout.GridPane;
import javafx.stage.Stage;
import javafx.geometry.HPos;
import javafx.scene.chart.BarChart;
import javafx.scene.chart.CategoryAxis;
import javafx.scene.chart.NumberAxis;
import javafx.scene.chart.XYChart;
import java.io.File;
import javafx.stage.FileChooser;
import javafx.stage.FileChooser.ExtensionFilter;

/**
 *
 * @author 16072277
 */
public class BarChartProgram extends Application {
    private TextField[] itemTextField = new TextField[10];
    private TextField[] valueTextField = new TextField[10];
    private CheckBox[] checkBoxes = new CheckBox[10];
    
    @Override
    public void start(Stage primaryStage) {
        Label title = new Label("Title:");
        TextField graphTitle = new TextField();
        Label xAxis = new Label("X-Axis Label:");
        TextField xAxisTitle = new TextField();
        xAxisTitle.setPromptText("Description of Items");
        Label yAxis = new Label("Y-Axis Label:");
        TextField yAxisTitle = new TextField();
        yAxisTitle.setPromptText("Description of Item Value");
        Button generateBarChart = new Button("Generate Bar Chart");
        Button generateFromCSV = new Button("Generate From CSV");        
        Label itemName = new Label("Item Name");
        Label value = new Label("Value");
        Label enabled = new Label("Enabled");
        
        GridPane contentGrid = new GridPane();
        contentGrid.setVgap(10);
        contentGrid.setHgap(15);
        
        GridPane.setHalignment(itemName, HPos.CENTER);
        GridPane.setHalignment(value, HPos.CENTER);
        GridPane.setHalignment(enabled, HPos.CENTER);
        
        contentGrid.add(title, 0, 0);
        contentGrid.add(graphTitle, 1, 0);
        contentGrid.add(xAxis, 0, 1);
        contentGrid.add(xAxisTitle, 1, 1);
        contentGrid.add(yAxis, 0, 2);
        contentGrid.add(yAxisTitle, 1, 2);
        contentGrid.add(generateBarChart, 0, 3);
        contentGrid.add(generateFromCSV, 0, 4);
        contentGrid.add(itemName, 2, 0);
        contentGrid.add(value, 3, 0);
        contentGrid.add(enabled, 4, 0);        
        contentGrid.addColumn(2, createTextFields(itemTextField));
        contentGrid.addColumn(3, createTextFields(valueTextField));
        contentGrid.addColumn(4, createCheckBoxes(checkBoxes));
        
        Scene contentContainer = new Scene(contentGrid, 685, 400);
        primaryStage.setTitle("Bar Chart Generator");
        primaryStage.setScene(contentContainer);
        primaryStage.setResizable(false);
        primaryStage.show();
        
        generateBarChart.setOnMouseClicked(new EventHandler<MouseEvent>() {
            @Override
            public void handle(MouseEvent me) {                
                for (int checkboxIndex = 0; checkboxIndex < checkBoxes.length; checkboxIndex++) {
                    if(checkBoxes[checkboxIndex].isSelected()) {
                        CategoryAxis xAxis = new CategoryAxis();
                        NumberAxis yAxis = new NumberAxis();
                        XYChart.Series bar = new XYChart.Series();
                        BarChart<String,Number> barChart = new BarChart<String,Number>(xAxis,yAxis);
                        
                        barChart.setTitle(graphTitle.getText());
                        xAxis.setLabel(xAxisTitle.getText());
                        yAxis.setLabel(yAxisTitle.getText());
                        barChart.setLegendVisible(false);
                        
                        for(int textFieldIndex = 0; textFieldIndex < valueTextField.length; textFieldIndex++) {
                            if(checkboxIndex >= textFieldIndex) {
                                bar.getData().add(new XYChart.Data(itemTextField[textFieldIndex].getText(), Integer.parseInt(valueTextField[textFieldIndex].getText())));
                            }
                        }
                        
                        Scene barChartContainer  = new Scene(barChart,500,500);
                        barChart.getData().addAll(bar);
                        primaryStage.setScene(barChartContainer);
                        primaryStage.setTitle(graphTitle.getText());
                        primaryStage.setResizable(false);
                        primaryStage.show();
                    }
                }
            }
        });
        
        generateFromCSV.setOnMouseClicked(new EventHandler<MouseEvent>() {
            @Override
            public void handle(MouseEvent me) {
                FileChooser fileChooser = new FileChooser();
                fileChooser.setTitle("Open Resource File");
                fileChooser.showOpenDialog(primaryStage);
                fileChooser.getExtensionFilters().add(new FileChooser.ExtensionFilter("CSV", "*.csv"));
            }
        });
    }
    
    public static void main(String[] args) {
        launch(args);
    }
    
    public TextField[] createTextFields(TextField[] textField){
        for(int textFieldIndex = 0; textFieldIndex < itemTextField.length; textFieldIndex++){
            textField[textFieldIndex] = new TextField();
            if (textField == itemTextField) {
                textField[textFieldIndex].setPromptText("Item Name");
            }
            if (textField == valueTextField) {
                textField[textFieldIndex].setPromptText("e.g. 50");
            }
        }
        
        return textField;
    }
    
    public CheckBox[] createCheckBoxes(CheckBox[] checkBox){
        for(int checkBoxIndex = 0; checkBoxIndex < checkBoxes.length; checkBoxIndex++){
            checkBox[checkBoxIndex] = new CheckBox();
            GridPane.setHalignment(checkBox[checkBoxIndex], HPos.CENTER);
        }
        return checkBox;
    }
}