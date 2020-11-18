/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package shapes;

/**
 *
 * @author 12039524
 */
public class Triangle  extends TwoDShape{
    
    public Triangle (int height, int base) {
       super(height, base); 
    }
    
        @Override
    public double getArea() {
        return (height * base)/2;
    }
    
}

