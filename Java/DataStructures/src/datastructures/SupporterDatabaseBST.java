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
public class SupporterDatabaseBST {
    private Supporter data; //Store Supporter objects
    private SupporterDatabaseBST left, right; //store left & right values
    private int treeSize; //store number of items in the tree
    
    
    public SupporterDatabaseBST(Supporter data) {
        this.data = data;
        left = right = null;
        treeSize = size();
    }
            
    public void put(Supporter data) {
        /*If supporter object name is alphabetically less than a node that 
        exists, place the node to a free slot to the left*/
        if(data.getName().compareTo(this.data.getName()) < 0) {
            if(left != null) {
                left.put(data);
            }
            else {
                left = new SupporterDatabaseBST(data);
                treeSize++;
            }
        }
        /*If supporter object name is alphabetically greater than a node that 
        exists, place the node to a free slot to the right*/
        else if(data.getName().compareTo(this.data.getName()) > 0) {
            if(right != null) {
                right.put(data);
            }
            else {
                right = new SupporterDatabaseBST(data);
                treeSize++;
            }
        }
        /*If supporter object already exists, save the previous value. Then
        replace the previous value with the new one. Finally display the
        overwritted object*/
        else {
            Supporter previousVal = this.data;
            this.data = data;
            System.out.println("Overwritten object: " + previousVal);
        }
    }
    
    public void clear() {
        data = null; //set the values stored to null
        treeSize = 0; //reset the number of items to zero
    }
    
    public Supporter get(SupporterDatabaseBST node, Supporter supporter) {
        /*If object is not found, return null*/
        if(node == null) {
            return null;
        }
        /*Traverse to the left to find the supporter object if name is 
        alphabetically greater than a node that exists. If found, return that 
        object*/
        if(supporter.getName().compareTo(node.data.getName()) < 0) {
            return get(node.left, supporter);
        }
        /*Traverse to the right to find the supporter object if the name is 
        alphabetically greater than a node that exists. If found, return that 
        object*/
        else if(supporter.getName().compareTo(node.data.getName()) > 0) {
            return get(node.right, supporter);
        }
        else {
            return node.data;
        }
    }

    public void printSupportersOrdered(SupporterDatabaseBST node) {
        /*In-order traversal systematically prints the names alphabetically*/
        if(node != null) {
            printSupportersOrdered(node.left);
            System.out.println(node.data.getName());
            printSupportersOrdered(node.right);
        }
    }
    
    public boolean isEmpty() {
        return treeSize == 0; //Return true iff treeSize returns 0
    }
    
    public int size() {
        return treeSize; //Return the number of items in the binary search tree
    }
            
    public Supporter successor(SupporterDatabaseBST node) {
        Supporter successor = node.data; //Store successor node
        /*Find successor node i.e. the node in the right subtree with the
        minimum value*/
        while(node.left != null) {
            successor = node.left.data;
            node = node.left;
        }
        return successor;
    }
    
    public SupporterDatabaseBST remove(SupporterDatabaseBST node, Supporter data) {
        /*Node is not found*/
        if(node == null) {
            return node;
        }
        /*If supporter object name is alphabetically less than a node that 
        exists but does not match, traverse to the left. If found, store the
        targeted node that will be deleted.*/
        if(data.getName().compareTo(node.data.getName()) < 0) {
            node.left = remove(node.left, data);
        }
        /*If supporter object name is alphabetically greater than a node that 
        exists but does not match, traverse to the right. If found, store the
        targeted node that will be deleted.*/
        else if(data.getName().compareTo(node.data.getName()) > 0) {
            node.right = remove(node.right, data);
        }
        /*If the left child node of the root does not exist, traverse to the
        right. If the right child node of the root does not exist, traverse
        to the left. If found, delete the node.*/
        else {
            if(node.left == null) {
                return node.right;
            }
            else if(node.right == null) {
                return node.left;
            }
            node.data = successor(node.right);
            node.right = remove(node, data);
        }
        return node;
    }
}

