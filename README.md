# DBA - Database Access

**THIS REPOSITORY DOES NOT CONTAIN THE DATABASE CREDENTIALS WHICH ARE USED FOR ACCESSING AND MANIPULATING THE DATA. IT ONLY CONTIANS THE CODE**

### Explanation
The repository will contain three files as follows:

1. `write.php`
    - Has 2 internal submodules. One stores the data into the database, the other temporarily saves it as the **LSV** (**L**ive **S**ensor **V**alue)
2. `live_sensor.php`
    - Accesses the **LSV** Table to get the latest reading from a specific sensor.
3. `full_sensor.php`
    - Downloads the entire table of a specific sensor as a `.csv` file.
