/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package testcode_16072277;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

/**
 *
 * @author 16072277
 */
public class TestCode_16072277 {

    public static void main(String[] args) {
        String exePath = "C:\\Users\\Peter\\chromedriver.exe";
        System.setProperty("webdriver.chrome.driver", exePath);
        String[] course = {"Computer Science", "Computer Science with Artificial Intelligence", "Computer Science with Mathematics"};
        int i = 0;
        
        WebDriver driver = new ChromeDriver();
        driver.manage().window().maximize();
        driver.get("https://www.leeds.ac.uk");
        driver.findElement(By.xpath("//*[@id='navItem1000']")).click();
        driver.findElement(By.xpath("//*[@id='navItem116000']")).click();
        driver.findElement(By.xpath("/html/body/div[3]/div[4]/div[1]/div/p/a")).click();
        
        while(i <= course.length - 1) {
            WebElement element = driver.findElement(By.xpath("//*[@id='searchCourse']"));
            System.out.println("Loop index i: " + i);
            if(i <= course.length - 1) {
                System.out.println("Search keyword: " + course[i]);
            }
            element.sendKeys(course[i]);
            driver.findElement(By.xpath("/html/body/div[3]/main/div/div/form/div/div/div/div/div[3]/button")).click();
            driver.findElement(By.xpath("/html/body/div[3]/main/div/div[3]/div/div[2]/table/tbody/tr[1]/td[1]/span/a"));
            driver.findElement(By.xpath("/html/body/div[3]/div[1]/div/div/div[2]/ul/li[1]/a")).click();
            i++;
        }
        
        driver.quit();
    }
    
}
