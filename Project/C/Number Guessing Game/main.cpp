
/**********************************************************************/
/*                                                                   */
/*              A program called "What's My Number?"  */
/*     The aim of the game is to guess the correct number.    */
/*                                                                   */
/*                   written by Oliver Bikar        */
/*                                                                    */
/**********************************************************************/


// What's My Number.cpp : Defines the entry point for the console application.
//


#include <stdio.h> // A library which will include printf() and scanf().
#include <time.h>  // Required for srand() to generate random seed.
#include <stdlib.h> // A library which will convert a string to a integer by using atoi().
#include <ctype.h> // A library which will state and transform characters.
#include <conio.h> // This will allow getch to be used and allow information to remain on the screen until a key has been pressed.
#include <string.h> // This will allow the program to use strcpy and strlen.

int checkNumber(char [10]);	// From the main function a string will be taken to find out if it is a number.
int isNumber(char [10]);   // This will check if the input the user has entered is a number.   

int upperboundary; // This will generate a number which is +1 greater than the highest number which can be randomly generated.    
int lowerboundary; // This will generate a number which is -1 lower than the highest number which can be randomly generated.

void main()
{
	
    int counter; // This is used to record the number of attempts to recieve the correct number.
    int answer; // The randomly generated number need to be guessed correctly. 
    char response; // This will provide the user a choice to either quit or restart the program.
    char input; // This is the number the user will enter after it is has converted to an integer.
    char strNO[10]; // This is a string which will be converterd in a program in order for it to be converted to an integer. 
    bool valid; // This will validate a statement as true or false. If the statement is true the program will execute the statement. If the statement is false the program will not execute a statement.                               
	int intNo; // This is a variable which will compare an input to the randomly generated number.  

    srand(time(NULL)); // This will generate a randomly generated number.
       
    do
	{
		system("cls");
		response = 'Q'; // The user can press Q to exit the loop. However they must guess the correct answer first.
		counter = 0; // The counter is set to zero each time the user starts the game.
		printf("\nWelcome to What's My Number.\nA random number has been generated.\nGuess the correct number."); // Introduction to the game.
              
		upperboundary = 100; // The user must enter a number within the bounds which is not above 100.
		lowerboundary = 1;  // The user must enter a number within the bound which is not below 1.
		
		int answer = rand() % 100 + 1; // A random number between 1 and 100 will be randomly generated.  
  
		do
		{
			do
			{
				valid = false; 
				printf("\nEnter a number between %d and %d: ", lowerboundary, upperboundary); 
				scanf("%s", strNO);  
				fflush(stdin); 
									                                                                                              
				intNo = checkNumber(strNO); 
				if (intNo < lowerboundary || intNo > upperboundary)	// If the user enters a number which is out of the intial boundary the program will execute the if statement.
				{
					printf("The number you have entered is out of bounds.");     
				}
   
				else // If the user enters a number which is within the intial bounds the program will execute the else statement. 
				{
					valid = true; 	
				}
			} while (!valid); 
			counter++; // The counter will increase by 1 each time the user enters a valid number. 

			if (intNo == answer) // If the user enters the correct number the program will execute the if statement.  
			{
				printf("\nCongratulations you have guessed the correct number."); 
				printf("\nYou have had %d attempts,",counter);
			}	

			else if (intNo > answer) // If the user enters a number which higher than the randomly generated number the program will execute the else if statement. 
			{
				printf("\nThe number you have entered is too high."); 
				upperboundary = intNo;                                                                                                                   
				
			}

			else if (intNo < answer) // If the user enters a number which is lower than the randomly generated number the program will execute the if statement.
			{
				printf("\nThe number you have entered is too low."); 
				lowerboundary = intNo;     
				
			}
       
			} while (intNo != answer);
		do
		{
			printf("\nEnter C to restart the game.\nOr Q to quit the game.");
			scanf("%c", &response);
			fflush(stdin);
				if (toupper(response) != 'Q' || toupper(response) != 'C') // The if statement will check if the user has entered the correct character. 	
			{                                                            
				printf("\nThe character you have entered is invalid."); // A message will be displayed on the screen to                                       
			}                                                                                  

		}while (toupper(response) != 'C' && toupper(response) != 'Q');
		
		
	}

	while (toupper(response) != 'Q'); 
	
		
		
}                                                                                                                           


int checkNumber(char str[10]) // Check number function will take a string from the main function because it needs to check if the string is a number. If the string tested is a number it will convert to an integer.
{
       int intNumber; 
       char number[10]; 
       int valid = 0; 
       strcpy(number, str); 
       while (!valid) 
       {
              valid = isNumber(number);  
              if (!valid) // If the user does not enter a number which is within the initial bounds the program will execute the if statement.
              {
                     printf("\nYou have not entered a valid number\n\n"); 
                     printf("\nPlease enter a whole number: "); 
                     scanf("%s", number); 
                     fflush(stdin); 
              }
              else // If the user has entered a valid number which is within the initial bounds the program will execute the else statement.
              {
                     intNumber = atoi(number); 
                     valid = 1; 
              }
       }
       return intNumber; 
}

int isNumber(char string [10]) // This will check if an input is a decimal digit.
{
       int valid = 1; 
       int len = strlen(string); 
       for (int i = 0; i < len; i++) 
              if (!isdigit(string[i])) 
              {
                     valid = 0; 
                     break; 
              }
       return valid; 
}


