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
public class Weapon extends Equipment{
    private final double attack;

    public Weapon(String name, double weight,double attack) {
        super(name, weight);
        this.attack = attack;
    }

   
    @Override
    public String getName() {
        return name;
    }

    @Override
    public double getWeight() {
        return weight;
    }
    
    public double getAttack(){
        return attack;
    }
            
    
}

