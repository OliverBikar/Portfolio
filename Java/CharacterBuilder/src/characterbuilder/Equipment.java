/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package characterbuilder;

/**
 *
 * @author 13068140
 */
public abstract class Equipment {
    String name;
    double weight;

    public Equipment (String name, double weight){
    this.name = name;
    this.weight = weight;
        
    }
    public abstract String getName();
    public abstract double getWeight();
            
}
