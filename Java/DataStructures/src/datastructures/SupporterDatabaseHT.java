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
public class SupporterDatabaseHT implements ISupporterDatabase {
    private Supporter[] table; //store hash table
    private int tableCapacity, tableSize, newTableCapacity; //store capacity and number of items
    
    public SupporterDatabaseHT(int max) {
        this.tableCapacity = max; //store specified hash table capacity
        table = new Supporter[max]; //hash table has capacity stored by max
        tableSize = size(); //store the value returned in size method
        newTableCapacity = (tableCapacity * 2) + 1; //store prime number capacity
    }
    
    @Override
    public void clear() {
        for(int i = 0; i < tableCapacity; i++) {
            table[i] = null; //Looping through the array sets all values to null
        }
        tableSize = 0; //reset the number of items in hash table to zero
    }
    
    @Override
    public boolean containsName(String name) {
        return get(name) != null; //return true iff object has key (name)
    }
    
    @Override
    public Supporter get(String name) {
        /*Store hash value of key (name) as index. Store amount of probes*/
        int index = hash(name), countProbes = 1;
        /*If object at hash value index matches key, return object*/
        while(table[index] != null) {
            if(table[index].getName().equals(name)) {
                return table[index];
            }
            /*Quadratic probing to resolve collisions in hash table*/
            index = (index + countProbes*countProbes++) % tableCapacity;
        }
        return null;
    }
    
    @Override
    public int size() {
        return tableSize; //Return the number of items in the hash table
    }
    
    @Override
    public boolean isEmpty() {
        return tableSize == 0; //Return true iff size() returns the value 0
    }
    
    @Override
    public Supporter put(Supporter supporter) {
        /*Store hash value of key (supporter name) as index. Store amount of 
        probes*/
        int index = hash(supporter.getName()), probe = index, countProbes = 1;
        do {
            /*If hash table exceeds 75% load-factor transfer keys to new table*/
            if((float) tableSize / tableCapacity > 0.75f) {
                resizeHashTable();
            }
            /*If index is free, insert key to that index then increment size*/
            if(table[probe] == null) {
                table[probe] = supporter;
                tableSize++;
            }
            /*If object's name at index & key's name match, key replaces object*/
            if(table[probe].getName().equals(supporter.getName())) {
                Supporter temp = get(table[probe].getName());
                table[probe] = supporter; //Supporter overwrites obtained object
                return temp; //Return previous object mapped to supplied name
            }
            /*Quadratic probing to resolve collisions in hash table*/
            probe = (index + countProbes * countProbes++) % tableCapacity;
        }while (index != probe);
        return null;
    }
    
    @Override
    public Supporter remove(String name) {
        /*Store hash value of the key (name) as index. Store amount of probes*/
        int index = hash(name), countProbes = 1;
        /*Quadratic probing to resolve collisions in hash table*/
        while(!table[index].getName().equals(name)) {
            index = (index + countProbes * countProbes++) % tableCapacity;
        }
        /*Rehash every key then decrement size*/
        for(index = (index + countProbes++) % tableCapacity; table[index] != null; index = (index + countProbes++) % tableCapacity) {
            Supporter temp = table[index];
            table[index] = null;
            put(temp);
        }
        tableSize--;
        return null;
    }
    
    @Override
    public void printSupportersOrdered() {
        String[] tableNames = new String[tableSize]; //Store object names
        int countName = 0; //index counter for tableNames
        /*Copy object names to the string array tableNames*/
        for (int i = 0; i < tableCapacity; i++) {
            if(table[i] != null) {
                tableNames[countName++] = get(table[i].getName()).getName();
            }
        }
        /*Rearrange the names alphabetically*/
        for(int i = 0; i < tableSize - 1; i++) {
            for(int j = 0; j < tableSize - i - 1; j++) {
                if(tableNames[j].compareTo(tableNames[j+1]) > 0) {
                    String temp = tableNames[j];
                    tableNames[j] = tableNames[j+1];
                    tableNames[j+1] = temp;
                }
            }
        }
        for (int i = 0; i < tableSize; i++) {
            System.out.println("Name: " + tableNames[i]); //output ordered names
        }
    }
    
    public int hash(String key) {
        int hashNum = 0; 
        for(int i = 0; i < key.length(); i++) {
            hashNum += (int)key.charAt(i);//store sum of ASCII code per character in string
        }
        return hashNum % tableCapacity; //return calculated hash value
    }
    
    public void resizeHashTable() {
        /*Store hash table with a capacity doubled to next prime number*/
        Supporter[] newTable = new Supporter[newTableCapacity];
        /*Copy the values from the old hash table to the new one*/
        for (int i = tableCapacity; i-- < 0;) {
            for (Supporter oldItems = table[i]; oldItems != null;) {
                Supporter temp = oldItems;
                int index = hash(temp.getName());
                oldItems = newTable[index];
                newTable[index] = temp;
            }
        }
    }
    
    public void log() {
        /*Store sequence of buckets visited and number of items in hash table*/
        int size = 1, count = 0;
        System.out.println("Hash table capacity (start): " + tableCapacity);
        for (int i = 0; i < tableCapacity; i++) {
            /*Display each added object visited along with its hash value*/
            if (table[i] != null && table[i] == put(table[i])) {           
                System.out.println("Added: " + get(put(table[i]).getName()).getName());
                System.out.println("Hash value: " + hash(table[i].getName()));
                while(count < i) {
                    count++; //Monitor the sequence of buckets visited
                }
                /*Display the sequence of buckets visited and the size each time
                a new item is added to the hash table*/
                System.out.println("Sequence of buckets visited: " + count);
                System.out.println("Size: " + size++);
                /*Display the load factor each time an item is added to the hash
                table if it is below 75%*/
                if((float)size / tableCapacity < 0.75f) {
                    System.out.println("Load factor: " + (float)size / tableCapacity);
                }
                /*Display the load factor when an object has exceeded 75%. Rehash 
                items in old hash table to a new one. This has a capacity doubled 
                to the next prime number of the old one. Also, display the capacity
                and size of the new hash table.
                */
                else {
                    System.out.println("Load factor: " + (float)size / tableCapacity + "(Exceeded 75% load factor)");
                    resizeHashTable();
                    System.out.println("New hash table capacity: " + newTableCapacity);
                    System.out.println("New hash table Size: " + tableSize);
                }
            }
        }
    }
}
