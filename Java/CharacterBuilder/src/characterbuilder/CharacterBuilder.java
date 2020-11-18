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
public class CharacterBuilder {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        Weapon w = new Weapon("Long Sword", 15,1000);
        Shield s = new Shield("Wood Shield", 5,1000);
        
        Character c = new Character("Bob", 2000 , w, s);
        
        System.out.println("Character Name: " + c.getName());
        System.out.println("Character Level: " + c.getLevel());
        System.out.println("Weapon: " + c.getWpn().getName());
        System.out.println("Attack : " + c.getAtk  ());
        System.out.println("Shield: " + c.getShld().getName());
        System.out.println("Defence: " + c.getDef());
        System.out.println("Total Weight:" + c.getWeight());
    }
    
}
