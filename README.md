# Elevators practice

### Commands

#### app:interactive

This command allows you to play with Elevators Bank in an interactive fashion. Number of elevators and number of floors must be passed as arguments when it's called.

```
$ php bin/console app:interactive num_of_elevators num_of_floors
```

All the elevators will be at the lowest floor initially.

#### app:csv

This command allows you to simulate a list of request as a CSV input file.

CSV file must begin with a row noting the number of elevators available. It must be followed by n rows (where n is the number of elevators) informing every reachable floor by the n-th elevator. Finally, there will be as many rows as requests, indicating the request's time, origin floor and destination floor.

There are two sample files under data/input folder.

```
$  php bin/console app:csv ./data/input/simpleSample.csv
```

### Reports

Each executed simulation (interactive or CSV) will generate a CSV report under data/report folder.

### Strategies

Two elevator selection strategies has been developed for this project
 - Nearest Elevator
 - Nearest And Less Used Elevator
 
Interactive command uses the first one, meanwhile CSV simulation command uses the last one.