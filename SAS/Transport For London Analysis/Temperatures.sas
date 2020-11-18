*Process the raw data file to conduct analysis on monthly temperatures at various London Underground Stations;
data cwork.averagetemperatures;
   *The variable used to store the month name can store upto 11 characters;
   length temp_month $17;
   /*Identify the raw data file to be read*/
   infile "&path\lu-average-monthly-temperatures.csv" dlm=',' dsd missover firstobs=2;
   *Read in and contain the year and month. The same applies for the temperature values 
    for Bakerloo Line, Central Line, Jubilee Line, Northern Line, Piccadily Line, Victoria 
    Line, Waterloo and City Line and Sub Surface Line;
   input temp_year temp_month Bakerloo Central Jubilee Northern Piccadily
         Victoria Waterloo_and_City Sub_surface_lines;
   *Display an error message in the log if the file is read incorrectly;
   if _ERROR_=1 then putlog _ALL_;
run;
/*Null hypothesis: check that the mean value for Bakerloo Line equals 27
  Alternative hypothesis: check if the mean value of Bakerloo line is higher than 27
  If the null hypothesis is rejected, then the alternative hypothesis is checked.*/
proc ttest data=cwork.averagetemperatures H0=27 sides=u alpha=0.05;
   title'TTest Of H0: Mean=27 In Bakerloo Line';
   var Bakerloo;
run;
title;
/*Null hypothesis: check that the mean value for Central Line equals 26
  Alternative hypothesis: check if the mean value of Bakerloo line is higher than 26
  If the null hypothesis is rejected, then the alternative hypothesis is checked.*/
proc ttest data=cwork.averagetemperatures H0=26 sides=u alpha=0.05;
   title'TTest Of H0: Mean=26 In Central Line';
   var Central;
run;
title;
/*Null hypothesis: check that the mean value for Jubilee Line equals 24
  Alternative hypothesis: check if the mean value of Bakerloo line is higher than 24
  If the null hypothesis is rejected, then the alternative hypothesis is checked.*/
proc ttest data=cwork.averagetemperatures H0=22 sides=u alpha=0.05;
   title'TTest Of H0: Mean=22 In Jubilee Line';
   var Jubilee;
run;
title;
/*Null hypothesis: check that the mean value for Northern Line equals 24
  Alternative hypothesis: check if the mean value of Bakerloo line is higher than 24
  If the null hypothesis is rejected, then the alternative hypothesis is checked.*/
proc ttest data=cwork.averagetemperatures H0=24 sides=u alpha=0.05;
   title'TTest Of H0: Mean=24 In Northern Line';
   var Northern;
run;
title;
/*Null hypothesis: check that the mean value for Piccadily Line equals 23
  Alternative hypothesis: check if the mean value of Bakerloo line is higher than 23
  If the null hypothesis is rejected, then the alternative hypothesis is checked.*/
proc ttest data=cwork.averagetemperatures H0=23 sides=u alpha=0.05;
   title'TTest Of H0: Mean=23 In Piccadily Line';
   var Piccadily;
run;
title;
/*Null hypothesis: check that the mean value for Victoria Line equals 24
  Alternative hypothesis: check if the mean value of Bakerloo line is higher than 24
  If the null hypothesis is rejected, then the alternative hypothesis is checked.*/
proc ttest data=cwork.averagetemperatures H0=24 sides=u alpha=0.05;
   title'TTest Of H0: Mean=24 In Victoria Line';
   var Victoria;
run;
title;
/*Null hypothesis: check that the mean value for Waterloo and City Line equals 22
  Alternative hypothesis: check if the mean value of Bakerloo line is higher than 22
  If the null hypothesis is rejected, then the alternative hypothesis is checked.*/
proc ttest data=cwork.averagetemperatures H0=22 sides=u alpha=0.05;
   title'TTest Of H0: Mean=22 In Waterloo and City Line';
   var Waterloo_and_City;
run;
title;
/*Null hypothesis: check that the mean value for Sub Surface Line equals 18
  Alternative hypothesis: check if the mean value of Bakerloo line is higher than 18
  If the null hypothesis is rejected, then the alternative hypothesis is checked.*/
proc ttest data=cwork.averagetemperatures H0=18 sides=u alpha=0.05;
   title'TTest Of H0: Mean=18 In Sub Surface Line';
   var Sub_surface_lines;
run;
title;
/*Perform statistical analysis to see the relationship between each variable used to store temperature values
 i.e. how closely related the temperatures in each London Underground Station are*/
proc corr data=cwork.averagetemperatures;
   title'Correlation Between The London Underground Stations';
   var Bakerloo Central Jubilee Northern Piccadily
       Victoria Waterloo_and_City Sub_surface_lines;
run;
title;
*Display errors in the log to specify which sections of the raw data file require cleaning;
data _null_;
   *Read averagetemperatures data step to track errors that need to be cleaned;
   set cwork.averagetemperatures;
   /*Output error message in the log and specify the month value that mismatches with 'January', 'February', 
     'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November' or 'December'*/
   if temp_month not in('January','February','March','April','May','June','July',
     'August','September','October','November','December') 
     then putlog 'INVALID MONTH (CLEAN THE DATA SET):' temp_month;
   *Output an error message in the log and specify the year value that is above today's year or below 2013;
   if temp_year>year(today()) or temp_year<2013 then putlog 
      'INVALID YEAR (CLEAN THE DATA SET):' temp_year;
run;
*Clean the month names within the data set;
data cwork.newaveragetemperatures;
   *Read averagetemperatures data step for cleaning purposes;
   set cwork.averagetemperatures;
   *Remove all spaces in character values and convert them to lowercase format;
   temp_month=compress(lowcase(temp_month));
   *The first character of the character values formed in the first if statement are converted to uppercase;
   if compress(lowcase(temp_month)) in('january','february','march','april','may','june',
   'july','august','september','october','november','december')
   then temp_month=propcase(temp_month);
   /*Check if temp_month is equivalent to 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 
     'September', 'October', 'November' or 'December'. Then store a date value forming the first day of that month 
     with temp_year set as the year*/
   if temp_month='January' then Month=mdy(1,1,temp_year);
   else if temp_month='February' then Month=mdy(2,1,temp_year);
   else if temp_month='March' then Month=mdy(3,1,temp_year);
   else if temp_month='April' then Month=mdy(4,1,temp_year);
   else if temp_month='May' then Month=mdy(5,1,temp_year);
   else if temp_month='June' then Month=mdy(6,1,temp_year);
   else if temp_month='July' then Month=mdy(7,1,temp_year);
   else if temp_month='August' then Month=mdy(8,1,temp_year);
   else if temp_month='September' then Month=mdy(9,1,temp_year);
   else if temp_month='October' then Month=mdy(10,1,temp_year);
   else if temp_month='November' then Month=mdy(11,1,temp_year);
   else if temp_month='December' then Month=mdy(12,1,temp_year);
   *Store the year of the date values created;
   Year=year(Month);
   *Month will display the date value as the month name, and the temperature values will be set to two decimal places;
   format Month monname3. Bakerloo Central Jubilee Northern Piccadily
          Victoria Waterloo_and_City Sub_surface_lines 8.2;
   *Change the column title from variable name to new title;
   label  Bakerloo='Bakerloo Line'
          Central='Central Line'
		  Jubilee='Jubilee Line'
		  Northern='Northern Line'
		  Piccadily='Piccadily Line'
		  Victoria='Victoria Line'
          Waterloo_and_City='Waterloo and City Line'
          Sub_surface_lines='Sub Surface Line';
run;
*Remove duplicate observations where all column values match with another observation;
proc sort data=cwork.newaveragetemperatures
          out=cwork.averagetemperatures_sorted
          noduplicates; *Compare all values of each observation to the previous one. Once match is found do not write to the output data set;
          by _all_;     *Sort all the values to retain observation ordering in the output data set;
run;
*Remove duplicate observations with different temperature values but the same month and year value;
proc sort data=cwork.averagetemperatures_sorted nodupkey;
   by Month Year; *Sort the values to retain their ordering in the output data set;
run;
data cwork.finalTemperatures;
   *Alter column ordering to make Year and Month the third and fourth column of the table;
   retain temp_year temp_month Year Month Bakerloo Central Jubilee Northern Piccadily
          Victoria Waterloo_and_City Sub_surface_lines;
   *Read in the sorted data set formed when removing duplicates;
   set cwork.averagetemperatures_sorted;
   *Discard observations where the year value is either above the year of today's date or below 2013;
   if Year>year(today()) or Year<2013 then delete;
   /*Discard observations where temp_month is not equivalent to 'January', 'February', 'March', 'April', 
     'May', 'June', 'July', 'August', 'September', 'October', 'November' or 'December'*/
   where temp_month in('January','February','March','April','May','June','July',
         'August','September','October','November','December');
   /*Exclude temp_year and temp_month from the data set. These were temporary variables used to produce 
     Month and Year*/
   drop temp_year temp_month;
run;
*Display the cleaned data set;
proc print data=cwork.finalTemperatures label noobs;
   title'London Underground Stations Monthly Temperatures';
   title2'(Degrees Celsius)';
run;
title;
*Produce a table that provides a number of distinct values within the data set;
proc freq data=cwork.finalTemperatures nlevels;
   title'Data Validation'; *Display the title 'Data Validation above the created table';
   ods noproctitle;		   *Hide default proc freq title;
   table _all_/noprint;    *Suppressed to display only the number of variable levels;
run;
title;
*Display a table showing the uniqueness between Month and Year;
proc freq data=cwork.finalTemperatures order=internal;
   title'Observation Uniqueness'; 				  *Display the title 'Observation Uniqueness';
   ods noproctitle;		                          *Hide default proc freq title;
   tables Year*Month/nocum nopercent norow nocol; *Suppress cummulative frequency, percentage, rows and columns;
run;
title;
*Produce a table monitoring overall mean values for each London Underground Station;
proc means data=cwork.finalTemperatures mean nolabels nonobs maxdec=2;
   title'Overall Average Temperatures In The London Underground Stations Data Set';
   *Include the London Underground Station temperatures in the order specified below;
   var Bakerloo Central Jubilee Northern Piccadily
       Victoria Waterloo_and_City Sub_surface_lines;
run;
title;
*Produce a table monitoring average temperatures per year;
proc means data=cwork.finalTemperatures mean nolabels nonobs maxdec=2;
   title'London Underground Stations Average Temperatures Per Year';
   *Include the London Undergorund Station temperatures in the order specified below;
   var Bakerloo Central Jubilee Northern Piccadily
       Victoria Waterloo_and_City Sub_surface_lines;
   class Year; *Identify subgroup values i.e. the year that the temperature was recorded;
run;
title;
*Produce a table monitoring the minimum and maximum temperatures in every London Underground Station per year;
proc means data=cwork.finalTemperatures min max nolabels nonobs maxdec=2;
   title'Minimum and Maximum Temperatures In Each London Underground Station Per Year';
   *Include the London Undergorund Station temperatures in the order specified below;
   var Bakerloo Central Jubilee Northern Piccadily
       Victoria Waterloo_and_City Sub_surface_lines;
   class Year; *Identify subgroup values i.e. the year that the temperature were recorded;
run;
title;
*Produce a table monitoring the most common temperatures in every London Underground Station per year;
proc means data=cwork.finalTemperatures mode nolabels nonobs maxdec=2;
   title'Most Common Temperatures In Each London Underground Station Per Year';
   *Include the London Undergorund Station temperatures in the order specified below;
   var Bakerloo Central Jubilee Northern Piccadily
       Victoria Waterloo_and_City Sub_surface_lines;
   class Year; *Identify subgroup values i.e. the year that the temperature was recorded;
run;
title;
