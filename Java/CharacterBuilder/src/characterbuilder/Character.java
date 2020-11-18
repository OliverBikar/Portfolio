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
public class Character {
    private String name;
    private int level;
    
    private Weapon wpn;
    private Shield shld;
   

    public Character (String name, int level, Weapon wpn, Shield shld){
        this.name = name;
        this.level = level;
        this.wpn = wpn;
        this.shld = shld;
    }


    public String getName(){
        return name;
    }
    public int getLevel(){
        return level;
    }
    
   public double getAtk(){
       return wpn.getAttack() + (level*4);
   }
   public double getDef() {
       return shld.getDefence() + (level*4);
   }
   public double getWeight() {
       return wpn.getWeight() + shld.getWeight();
   }

   public Weapon getWpn() {
       return wpn;
    }
   
   public Shield getShld(){
       return shld;
   }
}
