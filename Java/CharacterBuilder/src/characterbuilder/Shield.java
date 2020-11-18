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
public class Shield extends Equipment{
    private final double defence;

    public Shield(String name, double weight, double defence) {
        super(name, weight);
        this.defence = defence;
    }


    @Override
    public String getName() {
        return name;
    }

    @Override
    public double getWeight() {
        return weight;
    }
    
    public double getDefence(){
        return defence ;
    }
}