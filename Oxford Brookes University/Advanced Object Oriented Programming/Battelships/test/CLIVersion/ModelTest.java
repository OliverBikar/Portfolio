package CLIVersion;

import org.junit.Test;
import static org.junit.Assert.*;

/**
 *
 * @author 16072277
 */
public class ModelTest {
    
    /**
     * Test to ensure that the ships are placed in the given grid location.
     */
    @Test
    public void testOne() {
        Model model = new Model();
        
        assertEquals(model.isOccupied(2,2),true);
        assertEquals(model.isOccupied(2,3),true);
        assertEquals(model.isOccupied(2,4),true);
        assertEquals(model.isOccupied(2,5),true);
        assertEquals(model.isOccupied(2,6),true);
        assertEquals(model.isOccupied(5,2),true);
        assertEquals(model.isOccupied(6,2),true);
        assertEquals(model.isOccupied(3,9),true);
        assertEquals(model.isOccupied(4,9),true);
        assertEquals(model.isOccupied(5,9),true);
        assertEquals(model.isOccupied(6,9),true);
        assertEquals(model.isOccupied(8,3),true);
        assertEquals(model.isOccupied(8,4),true);
        assertEquals(model.isOccupied(8,5),true);
        assertEquals(model.isOccupied(9,8),true);
        assertEquals(model.isOccupied(9,9),true);
    }
    
    /**
     * Checks that the model records the location that have already been shot.
     */
    @Test
    public void testTwo() {
        Model model = new Model();
        
        assertFalse(model.hasAlreadyShot(2,2));
        model.attackShip(2,2);
        assertTrue(model.hasAlreadyShot(2,2));
        assertFalse(model.hasAlreadyShot(2,3));
        model.attackShip(2,3);
        assertTrue(model.hasAlreadyShot(2,3));
        assertFalse(model.hasAlreadyShot(2,4));
        model.attackShip(2,4);
        assertTrue(model.hasAlreadyShot(2,4));
        assertFalse(model.hasAlreadyShot(2,5));
        model.attackShip(2,5);
        assertTrue(model.hasAlreadyShot(2,5));
        assertFalse(model.hasAlreadyShot(2,6));
        model.attackShip(2,6);
        assertTrue(model.hasAlreadyShot(2,6));
        assertFalse(model.hasAlreadyShot(5,2));
        model.attackShip(5,2);
        assertTrue(model.hasAlreadyShot(5,2));
        assertFalse(model.hasAlreadyShot(6,2));
        model.attackShip(6,2);
        assertTrue(model.hasAlreadyShot(6,2));
        assertFalse(model.hasAlreadyShot(3,9));
        model.attackShip(3,9);
        assertTrue(model.hasAlreadyShot(3,9));
        assertFalse(model.hasAlreadyShot(4,9));
        model.attackShip(4,9);
        assertTrue(model.hasAlreadyShot(4,9));
        assertFalse(model.hasAlreadyShot(5,9));
        model.attackShip(5,9);
        assertTrue(model.hasAlreadyShot(5,9));
        assertFalse(model.hasAlreadyShot(6,9));
        model.attackShip(6,9);
        assertTrue(model.hasAlreadyShot(6,9));
        assertFalse(model.hasAlreadyShot(8,3));
        model.attackShip(8,3);
        assertTrue(model.hasAlreadyShot(8,3));
        assertFalse(model.hasAlreadyShot(8,4));
        model.attackShip(8,4);
        assertTrue(model.hasAlreadyShot(8,4));
        assertFalse(model.hasAlreadyShot(8,5));
        model.attackShip(8,5);
        assertTrue(model.hasAlreadyShot(8,5));
        assertFalse(model.hasAlreadyShot(9,8));
        model.attackShip(9,8);
        assertTrue(model.hasAlreadyShot(9,8));
        assertFalse(model.hasAlreadyShot(9,9));
        model.attackShip(9,9);
        assertTrue(model.hasAlreadyShot(9,9));
    }
    
    /**
     * Test to ensure that the game ends once all ships are destroyed.
     */
    @Test
    public void testThree() {
        Model model = new Model();
        
        assertTrue(model.isGameOver());
        model.attackShip(2,2);
        model.attackShip(2,3);
        model.attackShip(2,4);
        model.attackShip(2,5);
        model.attackShip(2,6);
        assertTrue(model.isGameOver());
        model.attackShip(5,2);
        model.attackShip(6,2);
        assertTrue(model.isGameOver());
        model.attackShip(3,9);
        model.attackShip(4,9);
        model.attackShip(5,9);
        model.attackShip(6,9);
        assertTrue(model.isGameOver());
        model.attackShip(8,3);
        model.attackShip(8,4);
        model.attackShip(8,5);
        assertTrue(model.isGameOver());
        model.attackShip(9,8);
        model.attackShip(9,9);
        assertFalse(model.isGameOver());
    }
    
}
