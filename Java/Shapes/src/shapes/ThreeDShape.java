/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package shapes;

/**
 *
 * @author 12039524
 */
public abstract class ThreeDShape extends AbstractShapes{
    int depth;
    
    public ThreeDShape(int height, int base, int depth) {
    super(height, base);
    this.depth = depth;
        
    }
 public abstract double getVolume();
}
