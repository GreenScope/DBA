# Error Codes

The code has been arranged in a way so that the first character is always `E` followed by a two digit number that denotes the error which occurred.

If the first character is not an `E` then there were no errors

| Error Code | Error Description                                              |
|:----------:|:---------------------------------------------------------------|
| EXX        | An unprecedented error occurred                                |
| E00        | Could not connect to the database                              |
| E01        | Could not find the locations table                             |
| E02        | No location matched the table                                  |
| E03        | Could not find the sensors table                               |
| E04        | No previous records found, assuming first entry and continuing |