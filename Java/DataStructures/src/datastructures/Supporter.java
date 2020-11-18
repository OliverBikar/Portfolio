/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package datastructures;

/**
 *
 * @author 16072277
 */
public class Supporter implements ISupporter {
    private String supporterID, supporterName; //store supporter ID and name
    
    /*Each object will have a supporter ID and supporter name.*/
    public Supporter(String supporterNum, String name) {
        this.supporterID = supporterNum;
        this.supporterName = name;
    }
    
    /*Return the supporter ID that the supporter object contains.*/
    @Override
    public String getID() {
        return supporterID;
    }
    
    /*Return the supporter name that the supporter object contains.*/
    @Override
    public String getName() {
        return supporterName;
    }
}
