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
public class DataStructures {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        SupporterDatabaseHT hashTable = new SupporterDatabaseHT(5);
        SupporterDatabaseBST tree = new SupporterDatabaseBST(new Supporter("",""));
        
        System.out.println("Hash value of quinton: " + hashTable.hash("quinton"));
        System.out.println("Hash value of hamilton: " + hashTable.hash("hamilton"));
        System.out.println("Hash value of garrick: " + hashTable.hash("garrick"));
        System.out.println("Hash value of bradshaw: " + hashTable.hash("bradshaw"));
        System.out.println("Hash value of hayes: " + hashTable.hash("hayes"));
        System.out.println("Hash value of Quinton: " + hashTable.hash("Quinton"));
        System.out.println("Hash value of Hamilton: " + hashTable.hash("Hamilton"));
        System.out.println("Hash value of Garrick: " + hashTable.hash("Garrick"));
        System.out.println("Hash value of Bradshaw: " + hashTable.hash("Bradshaw"));
        System.out.println("Hash value of Hayes: " + hashTable.hash("Hayes"));
        System.out.println("Hash value of QUINITON: " + hashTable.hash("QUINITON"));
        System.out.println("Hash value of HAMILTON: " + hashTable.hash("HAMILTON"));
        System.out.println("Hash value of GARRICK: " + hashTable.hash("GARRICK"));
        System.out.println("Hash value of BRADSHAW: " + hashTable.hash("BRADSHAW"));
        System.out.println("Hash value of HAYES: " + hashTable.hash("HAYES"));
        
        System.out.println("\nHash Table Size: " + hashTable.size());
        System.out.println("Empty? " + hashTable.isEmpty());
        System.out.println("Find quinton: " + hashTable.get("quinton"));
        System.out.println("Find bradshaw: " + hashTable.get("bradshaw"));
        System.out.println("Find ferguson: " + hashTable.get("ferguson"));
        System.out.println("quinton exists: " + hashTable.containsName("quinton"));
        System.out.println("bradshaw exists: " + hashTable.containsName("bradshaw"));
        System.out.println("ferguson exists: " + hashTable.containsName("ferguson"));
        hashTable.put(new Supporter("1","quinton"));
        System.out.println("Hash Table Size: " + hashTable.size());
        System.out.println("Empty? " + hashTable.isEmpty());
        System.out.println("Original Entry: " + hashTable.put(new Supporter("2","quinton")));
        System.out.println("New Entry: " + hashTable.get("quinton"));
        System.out.println("Hash Table Size: " + hashTable.size());
        System.out.println("Remove quinton: " + hashTable.remove("quinton"));
        System.out.println("Hash Table Size: " + hashTable.size());
        System.out.println("Empty? " + hashTable.isEmpty());
        hashTable.put(new Supporter("1","bradshaw"));
        System.out.println("Hash Table Size: " + hashTable.size());
        System.out.println("Empty? " + hashTable.isEmpty());
        System.out.println("Find bradshaw: " + hashTable.get("bradshaw"));
        System.out.println("bradshaw exists: " + hashTable.containsName("bradshaw"));
        hashTable.put(new Supporter("2","ferguson"));
        System.out.println("Hash Table Size: " + hashTable.size());
        System.out.println("Empty? " + hashTable.isEmpty());
        System.out.println("Find ferguson: " + hashTable.get("ferguson"));
        System.out.println("ferguson exists: " + hashTable.containsName("ferguson"));
        hashTable.clear();
        System.out.println("Hash Table Size: " + hashTable.size());
        System.out.println("Empty? " + hashTable.isEmpty());
        System.out.println("Find quinton: " + hashTable.get("quinton"));
        System.out.println("Find bradshaw: " + hashTable.get("bradshaw"));
        System.out.println("Find ferguson: " + hashTable.get("ferguson"));
        System.out.println("quinton exists: " + hashTable.containsName("quinton"));
        System.out.println("bradshaw exists: " + hashTable.containsName("bradshaw"));
        System.out.println("ferguson exists: " + hashTable.containsName("ferguson"));
        hashTable.put(new Supporter("1","hayes"));
        hashTable.put(new Supporter("2","yorke"));
        hashTable.printSupportersOrdered();
        hashTable.clear();
        hashTable.put(new Supporter("1","quinton"));
        hashTable.put(new Supporter("2","bradshaw"));
        hashTable.put(new Supporter("3","hamilton"));
        hashTable.log();

        System.out.println("\nBinary search tree size: " + tree.size());
        System.out.println("Empty? " + tree.isEmpty());
        tree.put(new Supporter("1","smith"));
        System.out.println("Binary search tree size: " + tree.size());
        System.out.println("Empty? " + tree.isEmpty());
        System.out.println("Find smith: " + tree.get(tree, new Supporter("1","smith")));
        System.out.println("Find quinton: " + tree.get(tree, new Supporter("2","quinton")));
        System.out.println("Find hamilton: " + tree.get(tree, new Supporter("3","hamilton")));
        System.out.println("Find garrick: " + tree.get(tree, new Supporter("4","garrick")));
        tree.put(new Supporter("2", "smith"));
        System.out.println("Find smith: " + tree.get(tree, new Supporter("2","smith")));
        System.out.println("Binary search tree size: " + tree.size());
        System.out.println("Empty? " + tree.isEmpty());
        tree.put(new Supporter("3","quinton"));
        tree.put(new Supporter("4","hamilton"));
        tree.put(new Supporter("5","garrick"));
        tree.printSupportersOrdered(tree);
        System.out.println("Remove garrick: " + tree.remove(tree, new Supporter("5", "garrick")));
        System.out.println("Find garrick: " + tree.get(tree, new Supporter("5","garrick")));
        System.out.println("Remove hamilton: " + tree.remove(tree, new Supporter("4", "hamilton")));
        System.out.println("Find hamilton: " + tree.get(tree, new Supporter("4","hamilton")));
        tree.clear();
        System.out.println("Binary search tree size: " + tree.size());
        System.out.println("Empty? " + tree.isEmpty());
    }
}
