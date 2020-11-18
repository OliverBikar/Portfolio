/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package shapes;

/**
 *
 * @author 12039524
 */
public class Shapes {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        Rectangle R1 = new Rectangle (12, 9);
        System.out.println ("The area of the rectangle is " + R1.getArea());
        
        Rectangle R2 = new Rectangle (8, 4);
        System.out.println ("The area of the rectangle is " + R2.getArea());
        
        Rectangle R3 = new Rectangle (7, 12);
        System.out.println ("The area of the rectangle is " + R3.getArea());
        
        Rectangle R4 = new Rectangle (6, 22);
        System.out.println ("The area of the rectangle is " + R4.getArea());
        
        Triangle T1 = new Triangle (12, 3);
        System.out.println ("The area of the triangle is " + T1.getArea());
        
        Triangle T2 = new Triangle (56, 2);
        System.out.println ("The area of the triangle is " + T2.getArea());
        
        Triangle T3 = new Triangle (22, 11);
        System.out.println ("The area of the triangle is " + T3.getArea());
        
        Triangle T4 = new Triangle (20, 10);
        System.out.println ("The area of the triangle is " + T4.getArea());
    }
}