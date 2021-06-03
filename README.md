# Digital Names Reseller Website



## Description

The Digital Names Reseller Website is designed to provide resellers of Digital Names with an ecommerce solution to sell digital names. Accompanying this asset is a decentralized, open commerce space for P2P selling of Digital Names.

To promote the greatest level of flexibility and customization, the Digital Names Reseller Website is provided as a full-functioning web application, but with a bare-bones front end design.

## Technologies Used

Technologies involved with the creation of the Digital Names Reseller Website include:

* HTML
* CSS
* Javascript (JQuery)
* PHP

Additionally, an SQL database was used. This means that SQL will be needed for any modifications of queries and related database functionalities. 

## Zipped Folder Installation

The complete contents of the Digital Names Reseller Website is contained within a zipped folder named "dn-reseller.zip". The process for installing the zipped folder for the website is as follows:

1. Download the zip file for the website by first clicking on the green "code" button within the github repo, and then by clicking on the "download zip" link in the resulting dropdown menu.

2. Navigate to "File Manager" in your C-panel and upload the "dn-reseller.zip" file to the root path (public_html) of your server that is hosting the domain name you will be using.

3. Once the zipped folder has been uploaded to the (public_html), extract the files from the folder. You should now have all files necessary for the website, within the (public_html) directory.

4. Navigate to the "MySQL Database Wizard" in your C-panel. Follow the steps provided, where you will do the following:
    * Item 4A - Create a database.
    * Item 4B - Create a database user.
    * Item 4C - Add user to the database. Be sure to select the checkbox for "ALL PRIVILEGES" and then click on "Next Step".

5. Navigate to your domain name in the browser of your choice. You should see the default admin setup form.

6. Fill in the fields with the information you used to create the database in Step 4. **(PLEASE NOTE: in the first field that contains "ex: localhost" you should enter the word "localhost", unless you have a special condition within your server configuration that would cause a conflict with using "localhost" as a defualt.)**

7. Click "Submit" and your website will now be live.

## Installation Via FTP

The complete contents of the Digital Names Reseller Website is contained within a zipped folder named "dn-reseller.zip". The process for installing the website files via FTP is as follows:

1. Download the zip file for the website by first clicking on the green "code" button within the github repo, and then by clicking on the "download zip" link in the resulting dropdown menu.

2. Once the zipped folder has been downloaded to your local drive, extract the files from the folder.

3. Using FTP utility software, such as FileZilla, upload the extracted files to the "public_html" folder of your domain name's server. You should now have all files necessary for the website, within the (public_html) directory.

4. Navigate to the "MySQL Database Wizard" in your C-panel. Follow the steps provided, where you will do the following:
    * Item 4A - Create a database.
    * Item 4B - Create a database user.
    * Item 4C - Add user to the database. Be sure to select the checkbox for "ALL PRIVILEGES" and then click on "Next Step".

5. Navigate to your domain name in the browser of your choice. You should see the default admin setup form.

6. Fill in the fields with the information you used to create the database in Step 4. **(PLEASE NOTE: in the first field that contains "ex: localhost" you should enter the word "localhost", unless you have a special condition within your server configuration that would cause a conflict with using "localhost" as a defualt.)**

7. Click "Submit" and your website will now be live.

## Site Administrator Setup

Upon going live with your Digital Names reseller website, an administrator (admin) will need to be setup in order to access the features pertaining to connecting with the Digital Names API, establishing warnings for low credit levels, the set up of affiliate programs, and more. The process for setting up the site administrator is as follows:

1. Navigate to "MY-DOMAIN/admin/admin_setup.php", where you will see a form to fill out and submit.

2. Enter a name, email address, password (NOTE: Make sure to save this information in a safe place), and then click submit.

3. Submitting the form will bring you to the admin login page at "MY-DOMAIN/admin/login.php", which is the url you will use from this point forward to access the administrator backend for the website. Enter the email and password you used in STEP 2 and then click "Login".

4. At this point you have now entered the administrator backend for the website and are free to adjust any settings that are necessary.