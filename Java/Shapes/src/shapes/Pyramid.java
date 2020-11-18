/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package shapes;

/**
 *
 * @author 12039524
 */
    public class Pyramid extends ThreeDShape {

    public Pyramid (int height, int base, int depth){ 
    super(height, base, depth);
    }

    @Override
    public double getVolume() {
        return (height * base * depth)/2;
    }
    
    }

