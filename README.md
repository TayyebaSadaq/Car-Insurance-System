# 🚗 Car-Insurance-System
This is a project from my second year - second semester in Application development.
The task was an innovative web portal that provides a dashboard to facilitate effective administration of client information. 

## 🗃️ Interactive Data Management Dashboard
The application should have the ability to Create, Read, Update and Delete crucial information

## 📊 Data Visualisation Dashboard
The dashboard should facilitate data management but also offer key insights into the data via visualisation. 

## 🏆 The Result
The result is a php based application that has a 4 main pages
- A Dashboard
- Drivers
- Cars
- Claims
Each page uses the CRUD functions regarding the data stored in the database with clear indications of when data has been edited, removed or added
Pagination links were used for seamless navigation through the data for the user allowing steps through the pages as well as moving to the beginning and end.

## 📋 Pre-requisites
You'll need XAAMP installed and will need to upload the sql file into a new database with the same name (car_insurance)
move the files from the repository into the XAAMP folder to the following directory
  > C:DRIVE/XAAMP/HTDOCS

In XAAMP after you have imported the sql file onto the MYSQL server, run both Apache and MYSQL. In your browser then open the following link
> localhost/car_insurance/frontend/dashboard.php

This will take you to the main dashboard which you can then use to navigate to the other pages using the sidebar. The data edited is saved into the MYSQL database and is therefore saved between uses, so if you close the broswer and re-open any changes made are saved.
