package cardgamesimulator;

import java.util.Random;

/**
 *
 * @author Oliver Bikar
 */
public class CardGameSimulator {

    public static void main(String[] args) {
        int[] deck = new int[52];
        int[] scores = new int[2];
        int[] cards = new int[2];
        
        deck(deck);
        int turn = 1;
        
        while(!isEmpty(deck)) {
            System.out.println("Turn: " + turn);
            turn++;
            System.out.println("");
            hand(deck,cards);
            scoreboard(cards,scores);
            System.out.println("");
        }
        
        System.out.println("Result:");
        displayWinner(scores);
    }
    
    public static void deck(int[] deck) {
        for (int i = 0; i < 4; i++) {
            for (int j = 0; j < 13; j++) {
                deck[j+13*i] = j+1;
            }
        }
    }
    
    public static boolean isEmpty(int[] deck) {
        int position = 0;
        while(position < deck.length && deck[position] == 0) {
            position++;
        }
        return position == deck.length;
    }
    
    public static void hand(int[] deck, int[] cards) {
        int playerNum = 1;
        
        for (int i = 0; i < cards.length; i++) {
            playerNum = playerNum + i;
            cards[i] = dealCard(deck);
            System.out.println("Player " + playerNum + " " + "Card " + cards[i]);
        }
        
        if(playerNum > 2) {
            playerNum = 0;
        }
    }
    
    public static int dealCard(int[] deck) {
        Random random = new Random();
        int position, card;
        position = random.nextInt(deck.length);
        
        while(deck[position] == 0) {
            position = random.nextInt(deck.length);
        }
        
        card = deck[position];
        deck[position] = 0;
        return card;
    }
    
    public static void scoreboard(int[] card, int[] score) {
        if (card[0] > card[1]) {
            score[0] += 2;
            System.out.println("Player 1 Score: " + score[0]);
            System.out.println("Player 2 Score: " + score[1]);
        }
        else if(card[0] == card[1]) {
            score[0]++;
            score[1]++;
            System.out.println("Player 1 Score: " + score[0]);
            System.out.println("Player 2 Score: " + score[1]);
        }
        else {
            score[1] += 2;
            System.out.println("Player 1 Score: " + score[0]);
            System.out.println("Player 2 Score: " + score[1]);
        }
    }
    
    public static void displayWinner(int[] score) {
        if (score[0] > score[1]) {
            System.out.println("You have won the card game");
        }
        else if(score[0] == score[1]) {
            System.out.println("Tie");
        }
        else {
            System.out.println("You have lost the card game");
        }
    }
    
}
