*Process the raw data file to conduct analysis on the number of different bus types per year;
data cwork.bustypes;
   *bus_type store upto 15 characters and 16 for drive_train_type;
   length bus_type $15 drive_train_type $16;
   *Identify the raw data file to be read and ignore the first oberservation (headings);
   infile "&path\tfl buses type.csv" dlm=',' firstobs=2;
   *Read in and contain the values for bus_type, drive_train_type, Year and number_of_buses;
   input bus_type drive_train_type Year number_of_buses;
   *Display an error message in the log if the file is read incorrectly;
   if _ERROR_=1 then putlog _ALL_;
run;
/*Null hypothesis: check that the mean value for number of buses equals 980
  Alternative hypothesis: check if the mean value of number of buses is higher than 980
  If the null hypothesis is rejected, then the alternative hypothesis is checked.*/
proc ttest data=cwork.bustypes H0=980 sides=u alpha=0.05;
   title'TTest Of H0: Mean=980 Buses Available';
   var number_of_buses;
run;
/*Perform statistical analysis to see the relationship between each variable used to store number of buses
 i.e. how closely related the year and number of buses are*/
proc corr data=cwork.finalBusTypes;
   title'Correlation Between Year and Number of Buses Available';
   var Year number_of_buses;
run;
title;
*Display errors in the log to specify which sections of the raw data file require cleaning;
data _null_;
   *Read bustypes data step to track errors that need to be cleaned;
   set cwork.bustypes;
   /*Output error message in the log and specify bus type values that are not equivalent to
     'New Routemaster', 'Routemaster', 'Artic', 'Single deck' or 'Double deck'*/
   if bus_type not in('New Routemaster','Routemaster','Artic','Single deck','Double deck')
      then putlog 'INVALID BUS TYPE (CLEAN THE DATA SET):' bus_type;
   /*Output error message in the log and specify drive train type values that are not equivalent to
	 'Hybrid', 'Diesel', 'Fuel Cell/Hybrid' or 'Electric'*/
   if drive_train_type not in('Hybrid','Diesel','Fuel Cell/Hybrid','Electric')
      then putlog 'INVALID DRIVE TRAIN TYPE (CLEAN THE DATA SET):' drive_train_type;
   *Output an error message in the log and specify the year value that is above today's year or below 2010;
   if Year>year(today()) or Year<2010 then putlog 'INVALID YEAR (CLEAN THE DATA SET):' Year;
run;
*Clean the values stored in bus_type and drive_train_type;
data cwork.newbustypes;
   *Read bustypes data step for cleaning purposes;
   set cwork.bustypes;
   *Values for year will be extracted and store from a temporary date made within the program;
   Year=year(mdy(1,1,Year));
   /*Convert bus types to lowercase and ensure that extra spacing is removed. If it matches values 
     'routemaster' or 'artic', convert the first character to uppercase. If it matches the following 
     with no extra spacing then change: 
     1)'single deck' for 'Single deck'
     2)'double deck' for 'Double deck'
     3)'new routemaster' for 'New Routemaster'*/
   if lowcase(bus_type) in('routemaster','artic') or lowcase(strip(bus_type)) in('routemaster','artic') 
      then bus_type=propcase(bus_type);
   else if lowcase(bus_type) in('single deck') or strip(lowcase(bus_type)) eq 'single deck' or compbl(lowcase(bus_type)) 
           eq 'single deck' then bus_type=cat('Single',' deck');
   else if lowcase(bus_type) in('double deck') or strip(lowcase(bus_type)) eq 'double deck' or compbl(lowcase(bus_type)) 
           eq 'double deck' then bus_type=cat('Double',' deck');
   else if lowcase(bus_type) in('new routemaster') or strip(lowcase(bus_type)) eq 'new routemaster' or compbl(lowcase(bus_type)) 
           eq 'new routemaster' then bus_type=cat('New',' Routemaster');
   /*Convert engine types to lowercase and ensure that extra spacing is removed. If it matches values 'hybrid', 
     'diesel' or 'electric', convert the first character to uppercase. If it matches 'fuel cell/hybrid' then
     change it to display 'Fuel Cell/Hybrid'*/
   if lowcase(drive_train_type) in('hybrid','diesel','electric') or lowcase(strip(drive_train_type)) in 
      ('hybrid','diesel','electric') then drive_train_type=compress(propcase(drive_train_type));
   else if lowcase(drive_train_type) in('fuel cell/hybrid') or strip(lowcase(drive_train_type)) eq 'fuel cell/hybrid'
           then drive_train_type=catx('/','Fuel Cell','Hybrid');
   format  number_of_buses 8.0; *The number of buses stored is formatted to zero decimal places;
   /*Change the column title from variable name to new name for the columns presenting bus type, 
     drive train type and number of buses*/;
   label   bus_type='Bus Type' 
           drive_train_type='Engine Type' 
           number_of_buses='Number of Buses';
run;
*Remove duplicate observations where all column values match with another observation;
proc sort data=cwork.newbustypes
           out=cwork.BusTypes_sorted
           noduprecs; *Compare all values of each observation to the previous one. Once match is found do not write to the output data set;
           by Year;   *Sort the order of observations by the value of Year;
run;
*Remove duplicate observations that have the same year, bus type and drive train type;
proc sort data=cwork.BusTypes_sorted nodupkey;
   by Year bus_type drive_train_type; *Sort the observations by the values of year, bus type and engine type;
run;
*Clean the raw data file's statistics on total number of buses;
data cwork.finalBusTypes;
   *Read BusTypes_sorted data step for cleaning purposes;
   set cwork.BusTypes_sorted;
   *Sort the order of observations by the values of Year;
   by Year;
   *retain number_of_buses year_total;
   *Change column title from variable name to a new title;
   label total='Total Number Of Buses Per Year';
   /*Reset the stored value of year_total to 0 when detecting a new year group.
     total stores total number of buses in the monitored year group. count 
     increments by 1 and used an index for the number stored in the variable total*/
   if first.Year then year_total=0;
   year_total+number_of_buses;
   count+1;
   /*Each year group has 10 observations of bus records. When adding together the number of buses
     stored in each obersavtion, display only the final total.*/
   if first.Year then count=1;
   if count=10 then total=year_total;
   *Discard the variables count and year_total from the output data set;
   drop count year_total;
   *Delete observations containing the character value 'Total';
   if bus_type eq 'Total' or drive_train_type eq 'Total' then delete;
   /*Discard observations where the bus type is not equivalent to 'New Routemaster','Routemaster','Artic',
	 'Single deck' or 'Double deck' and if drive train type is not equivalent to 'Hybrid','Diesel',
     'Fuel Cell/Hybrid' or 'Electric'*/
   where bus_type in('New Routemaster','Routemaster','Artic','Single deck','Double deck') and
         drive_train_type in('Hybrid','Diesel','Fuel Cell/Hybrid','Electric');
   *Discard observations where the year value is either above the year of today's date or below 2013;;
   if Year>year(today()) or Year<2010 then delete;
run;
*Display the cleaned data set;
proc print data=cwork.finalBusTypes label noobs;
   title'Number of Available Bus Types Per Year';
run;
title;
*Produce a table that provides a number of distinct values within the data set;
proc freq data=cwork.finalBusTypes nlevels;
   title'Data Validation';
   ods noproctitle;		*Hide default proc freq title;
   table _all_/noprint;	*Suppress the table to show only the variable levels;
run;
title;
*Produce a table showing uniqueness between bus type, engine type and year;
proc freq data=cwork.finalBusTypes order=internal;
   title'Observation Uniqueness';
   *Hide default proc freq title;
   ods noproctitle;
   *Suppress cumulative frequency, percentage, rows and columns. Also display the table in list format;
   tables bus_type*drive_train_type*Year/nocum nopercent norow nocol list;
   *Split the table for each year group;
   by Year;
run;
title;
*Produce a table showing the total number of buses for all drive train types;
proc freq data=cwork.finalBusTypes;
   title'Total Number of Buses With Specific Engine Type';
   *Hide default proc freq title;
   ods noproctitle;
   *Suppress the cumulative frequency, percentage, rows and columns;
   tables bus_type*drive_train_type/nocum nopercent norow nocol;
run;
title;
*Produce a table monitoring the maximum amount of buses per year;
proc means data=cwork.finalBusTypes max nolabels nonobs maxdec=0;
   title'Maximum Number of Buses Available Per Year';
   var number_of_buses; *Only include the variable number_of_buses within the table;
   class Year; 			*Identify subgroup values i.e. the year that the number of buses were recorded;
run;
title;
*Produce a table monitoring the average number of buses per year. These will be categorised by year and engine type;
proc means data=cwork.finalBusTypes mean nolabels nonobs maxdec=0;
   title'Average Number Of Buses Per Year By Engine Type';
   var number_of_buses; 			*Only include the variable number_of_buses in the table;
   class Year drive_train_type; 	*Identify subgroup values i.e. the year where no. of buses were recorded and the engine type;
run;
title;
