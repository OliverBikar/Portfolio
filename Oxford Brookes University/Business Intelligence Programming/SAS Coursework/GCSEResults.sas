*Process the raw data file to conduct analysis on statistics for GCSE results in 2015/16 and 2016/17;
data cwork.resultsGCSE;
   *Code can store upto 9 characters, 27 for Area, 7 for Year and 4 for Gender;
   length Code $9 Area $27 Year $7 Gender $4;
   *Identify the raw data file to be read. Detect missing values and skip first observation (heading);
   infile "&path\gcse results.csv" dlm=',' dsd missover firstobs=2;
   *Read in and contain the values for Code, Area, Year, Gender, Pupils, Attainment and Progress;
   input Code Area Year Gender Pupils Attainment Progress;
   *Display an error message in the log if the file is read incorrectly;
   if _ERROR_=1 then putlog _ALL_;
run;
*Test the difference in student attainment mean values of the year groups;
proc ttest data=cwork.resultsGCSE;
   title'Test Mean Difference In Student Attainment';
   class Year;
   var Attainment;
run;
title;
*Test the difference in student progress mean values of the year groups;
proc ttest data=cwork.resultsGCSE;
   title'Mean Difference In Student Progress';
   class Year;
   var Progress;
run;
title;
*Test the difference in the mean value of pupils per year group;
proc ttest data=cwork.resultsGCSE;
   title'Pupils Mean Difference';
   class Year;
   var Pupils;
run;
title;
*Test the relationship between male and female attainment and progress;
proc corr data=cwork.finalResultsGCSE;
   title'Correlation Between Male and Female Attainment and Progress';
   var Attainment Progress;
   by Gender;
   where Gender in('Boys','Girl');
run;
title;
*Display errors in the log to specify which sections of the raw data file need to be cleaned;
data _null_;
   *Read resultsGCSE data step to track errors that need to be cleaned;
   set cwork.resultsGCSE;
   *If the value of Code mismatch to the ones below, output an error message in the log;
   if Code not in('E09000001','E09000002','E09000003','E09000004','E09000005',
      'E09000006','E09000007','E09000008','E09000009','E09000010','E09000011',
      'E09000012','E09000013','E09000014','E09000015','E09000016','E09000017',
      'E09000018','E09000019','E09000020','E09000021','E09000022','E09000023',
      'E09000024','E09000025','E09000026','E09000027','E09000028','E09000029',
      'E09000030','E09000031','E09000032','E09000033','E13000001','E13000002',
      'E12000001','E12000002','E12000003','E12000004','E12000005','E12000006',
      'E12000007','E12000008','E12000009','E92000001')
	  then putlog 'INVALID CODE (CLEAN THE DATA SET):' Code;
   *If the value of Area mismatch to the ones below, output an error message in the log;
   if Area not in('Barnet','Bexley','Brent','Bromley','Camden','Croydon','Ealing',
      'Enfield','Greenwich','Hackney','Haringey','Harrow','Havering','Hillingdon','Hounslow',
      'Islington','Lambeth','Lewisham','Merton','Newham','Redbridge','Southwark','Sutton',
      'Wandsworth','Westminster','East','London','England','Tower Hamlets','Waltham Forest',
      'Inner London','Outer London','North East','North West','East Midlands','West Midlands',
      'South East','South West','Barking and Dagenham','Hammersmith and Fulham',
      'Kensington and Chelsea','Kingston upon Thames','Richmond upon Thames','City of London',
      'Yorkshire and the Humber') then putlog 'INVALID AREA (CLEAN THE DATA SET):' Area;
   *If the value of Year is a mismatch to '2015/16' or '2016/17', output an error message in the log;
   if Year not in('2015/16','2016/17') then putlog 'INVALID YEAR (CLEAN THE DATA SET):' Year;
   *If the value of Gender is a mismatch to 'Boys','Girl' or 'All' then output an error message in the log;
   if Gender not in('Boys','Girl','All') then putlog 'INVALID GENDER (CLEAN THE DATA SET):' Gender;
run;
*Clean the values stored in Code and Area;
data cwork.newresultsGCSE;
   *Read the resultsGCSE data step for cleaning purposes;
   set cwork.resultsGCSE;
   *Convert the first character of the value stored in Code to uppercase and remove all spacing;
   Code=compress(propcase(Code));
   /*Remove trailing and leading blanks and also additional blanks between two or more worded
     character values. Then convert the first character to lowercase*/
   Area=compbl(strip(lowcase(Area)));
   *Convert the values stored in Gender to lowercase and remove all spacing;
   Gender=compress(lowcase(Gender));
   /*Convert the Area to lowercase and convert the first character of one worded character
     values to uppercase. With the following:
     1)Two worded character values. Convert the first character of each word to uppercase.
     2)Three worded character values. Convert the first character of the first and third word 
       to uppercase.
     3)Four worded character values. Convert the first character of the first and fourth word
       to uppercase.*/
   if compress(lowcase(Area)) in('barnet','bexley','brent','bromley','camden','croydon','ealing',
      'enfield','greenwich','hackney','haringey','harrow','havering','hillingdon','hounslow',
      'islington','lambeth','lewisham','merton','newham','redbridge','southwark','sutton',
      'wandsworth','westminster','east','london','england') then Area=propcase(compress(Area));
   else if strip(compbl(lowcase(Area))) in('tower hamlets','waltham forest','inner london','outer london',
           'north east','north west','east midlands','west midlands','south east','south west')
           then Area=catx(' ',propcase(scan(Area,1,',')),scan(Area,2,','));
   else if strip(compbl(lowcase(Area))) in('barking and dagenham','hammersmith and fulham','kensington and chelsea') then do;
           temp_area=catx(' ',propcase(scan(Area,1,',')),(scan(Area,2,',')),(scan(Area,3,',')));
		   Area=tranwrd(temp_area,'And','and'); *Replace the word 'And' with the word 'and';
   end;
   else if strip(compbl(lowcase(Area))) in('kingston upon thames','richmond upon thames') then do;
           temp_area=catx(' ',propcase(scan(Area,1,',')),(scan(Area,2,',')),(scan(Area,3,',')));
		   *Replace the word 'Upon' with the word 'upon';
		   Area=tranwrd(temp_area,'Upon','upon');
   end;
   else if strip(compbl(lowcase(Area))) in('city of london') then Area=catx(' ','City of','London');
   else if strip(compbl(lowcase(Area))) in('yorkshire and the humber') then Area=catx(' ','Yorkshire and','the Humber');
   *Convert the first character of the value to uppercase if Gender is equivalent to 'boys', 'girl' and 'all';
   if Gender in('boys','girl','all') then Gender=propcase(compress(Gender));
   *Discard observations that mismatch Code values specified below;
   where Code in('E09000001','E09000002','E09000003','E09000004','E09000005','E09000006','E09000007',
                 'E09000008','E09000009','E09000010','E09000011','E09000012','E09000013','E09000014',
                 'E09000015','E09000016','E09000017','E09000018','E09000019','E09000020','E09000021',
                 'E09000022','E09000023','E09000024','E09000025','E09000026','E09000027','E09000028',
                 'E09000029','E09000030','E09000031','E09000032','E09000033','E13000001','E13000002',
                 'E12000001','E12000002','E12000003','E12000004','E12000005','E12000006','E12000007',
                 'E12000008','E12000009','E92000001');
   *Discard the variable temp_area from the output data set;
   drop temp_area;
run;
*Remove duplicate observations where all column values match with another observation;
proc sort data=cwork.newresultsGCSE
           out=cwork.resultsGCSE_sorted
           noduprecs; *Compare all values of each observation to the previous one. Once match is found do not write to the output data set;
		   *Order observations by the values of Pupils, Attainment and Progress in descending order;
           by descending Pupils descending Attainment descending Progress;
run;
*Remove duplicate observations that have same Code, Area, Year and Gender but different Attainment and Progress;
proc sort data=cwork.resultsGCSE_sorted nodupkey;
   *Sort the order of observations by the values of Code, Area, Year and Gender;
   by Code Area Year Gender; 
run;
*Sort the order of the observations by Gender and descending Year;
proc sort data=cwork.resultsGCSE_sorted;
   by Gender descending Year;
run;
*Substitute the Gender value 'Boys' to 'Male' and 'Girl' to female. Any other value is substituted for the value 'Invalid';
proc format;
   value $Gender
       'Boys'='Male'
	   'Girl'='Female'
	   'All'='All'
	   other='Invalid';
run;
*Clean the values stored in Area;
data cwork.finalResultsGCSE;
   *Read the resultsGCSE_sorted data step for cleaning purposes;
   set cwork.resultsGCSE_sorted;
   *Enables Gender value substitution. The values of:
    1)Pupils are displayed to zero decimal places
    2)Attainment are displayed to one decimal place
    3)Progress are displayed to two decimal places;
   format Gender $Gender. Pupils 8.0 Attainment 8.1 Progress 8.2;
   *Discard observations that mismatch the values below in the variable Area;
   where Area in('Barnet','Bexley','Brent','Bromley','Camden','Croydon','Ealing',
         'Enfield','Greenwich','Hackney','Haringey','Harrow','Havering','Hillingdon','Hounslow',
         'Islington','Lambeth','Lewisham','Merton','Newham','Redbridge','Southwark','Sutton',
         'Wandsworth','Westminster','East','London','England','Tower Hamlets','Waltham Forest',
         'Inner London','Outer London','North East','North West','East Midlands','West Midlands',
         'South East','South West','Barking and Dagenham','Hammersmith and Fulham',
         'Kensington and Chelsea','Kingston upon Thames','Richmond upon Thames','City of London',
         'Yorkshire and the Humber');
   *Discard observations where the gender value is not 'Boys', 'Girl' or 'All';
   if gender not in('Boys','Girl','All') then delete;
   *Discard observations where the year value is not 2015/16 or 2016/17;
   if Year not in("2015/16","2016/17") then delete;
run;
*Display the cleaned data set;
proc print data=cwork.finalResultsGCSE label noobs;
   title'GCSE Results';
run;
title;
*Produce a table that provides a number of distinct values within the data set;
proc freq data=cwork.finalResultsGCSE nlevels;
   title'Data Validation'; *Display the title 'Data Validation';
   ods noproctitle;		   *Hide default proc freq title;
   table _all_/noprint;    *Suppress the table to show only the variable levels;
run;
title;
*Produce a table showing uniqueness between Code, Area, Year and Gender;
proc freq data=cwork.finalResultsGCSE order=freq;
   title'Observation Uniqueness';
   *Suppress cumulative frequency, percentage, rows and columns. Produce a list format table;
   tables Code*Area*Year*Gender/nocum nopercent norow nocol list;
   *Hide default proc freq title;
   ods noproctitle;
   *Split the table. One table for Male statistics, another for Female statistics and lastly another for both i.e. All;
   by Gender;
run;
title;
*Produce a table monitoring overall mean for Pupils, Attainment and Progress;
proc means data=cwork.finalResultsGCSE mean nolabels nonobs maxdec=2;
   title'Average Pupils, Attainment & Progress Overall In Data Set';
   var Pupils Attainment Progress; *Only include the variables Pupils, Attainment and Progress in the table;
run;
title;
*Produce a table monitoring overall mean for Attainment and Progress per year;
proc means data=cwork.finalResultsGCSE mean nolabels nonobs maxdec=2;
   title'Average Attainment & Progress Per Year';
   var Attainment Progress; *Only include the variables Attainment and Progress in the table;
   class Gender Year;       *Identify subgroup values i.e. the year of the student's GCSE Results and gender;
run;
title;
*Produce a table monitoring the most common attainment and progress;
proc means data=cwork.finalResultsGCSE mode nolabels nonobs maxdec=2;
   title'Most Common Attainment & Progress Per Year';
   var Attainment Progress; *Only include the variables Attainment and Progress in the table;
   class Gender Year; 		*Identify subgroup values i.e. the year of the student's GCSE Results and gender;
run;
title;
*Produce a table monitoring the minimum and maximum attainment and progress per year;
proc means data=cwork.finalResultsGCSE min max nolabels nonobs maxdec=2;
   title'Minimum and Maximum Attainment & Progress Per Year';
   var Attainment Progress;	*Only include the variables Attainment and Progress in the table;
   class Gender Year; 		*Identify subgroup values i.e. the year of the student's GCSE Results and gender;
run;
title;
*produce a table monitoring the average amount of pupils per year.;
proc means data=cwork.finalResultsGCSE mean nolabels nonobs maxdec=0;
   title'Average Number Of Pupils Per Year';
   var Pupils; 	*Only include the variable Pupils in the table;
   class Year; 	*Identify subgroup values i.e. the year of the student's GCSE Results;
run;
title;
*Produce a table monitoring the most common amount of pupils per year.;
proc means data=cwork.finalResultsGCSE mode nolabels nonobs maxdec=0;
   title'Most Common Number Of Pupils Per Year';
   var Pupils;  *Only include the variable Pupils in the table;
   class Year;	*Identify subgroup values i.e. the year of the student's GCSE Results;
run;
title;
*Produce a table monitoring the average amount of male and female pupils per year;
proc means data=cwork.finalResultsGCSE mean nolabels nonobs maxdec=0;
   title'Average Number Of Male and Female Pupils Per Year';
   var Pupils;                     *Only include the variable Pupils in the table;
   class Year Gender;              *Identify subgroup values i.e. the year of the student's GCSE Results and gender;
   where Gender in('Boys','Girl'); *Discard the category 'All' for Gender;
run;
title;
*Produce a table monitoring the minimum and maximum amount of male and female pupils per year;
proc means data=cwork.finalResultsGCSE min max nolabels nonobs maxdec=0;
   title'Minimum And Maximum Number Of Male and Female Pupils Per Year';
   var Pupils;                     *Only include the variable Pupils in the table;
   class Year Gender;              *Identify subgroup values i.e. the year of the student's GCSE Results and gender;
   where Gender in('Boys','Girl'); *Discard the category 'All' for Gender;
run;
title;
