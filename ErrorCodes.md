# Error Codes

The code has been arranged in a way so that the first character is always `E` followed by a two digit number that denotes the error which occurred.

If the first character is not an `E` then there were no errors

| Error Code | Error Description                                              |
|:----------:|:---------------------------------------------------------------|
| EXX        | An unprecedented error occurred                                |
| E00        | Could not connect to the database                              |
| E01        | Missing parameter                                              |
| E02        | Invalid ID                                                     |
| E03        | Invalid timestamp                                              |
| E04        | Invalid parameter                                              |
| E05        | Could not find the locations table                             |
| E06        | Could not find the recordings table                            |
| E07        | Could not find live values table                               |
| E08        | Unable to delete last live value                               |

| Warning Code | Warning Description                      |
|:------------:|:-----------------------------------------|
| W01          | No previous records found in recordings  |
| W02          | No previous records found in live values |
