# Scalo req-task

Thank you for inviting me to this process, here is my solution and steps I'd like to commit
in a normal "dev-day".

## Development

Use provided `Makefile` in order to run this apps (unit tests). `Docker + docker-compose` must be installed
on the host machine. Tested on _Ubuntu v22_:

```bash
$ docker -v
# Docker version 24.0.5, build ced0996

$ docker-compose -v
# docker-compose version 1.29.2, build 5becea4c
```

The following `Makefile` commands are available:

```text
bash                           Runs container in bash mode
start                          Start local env and tests
tests_acceptance               Runs acceptance test
tests_phpstan                  Runs phpstan analysis
tests_unit                     Runs unit tests
```

## APP Logic

### Client specification / story

```text
Football World Cup Score Board:

You are working on a sports data company. And we would like you to develop a new
Live Football World Cup Score Board that shows matches and scores.

The boards support the following operations:

1. Start a game. When a game starts, it should capture (being initial score 0-0)
a. Home team
b. Away Team

2. Finish a game. It will remove a match from the scoreboard.

3. Update score. Receiving the pair score; home team score and away team score
updates a game score

4. Get a summary of games by total score. Those games with the same total score
will be returned ordered by the most recently added to our system.

As an example, being the current data in the system:

a. Mexico - Canada: 0 – 5
b. Spain - Brazil: 10 – 2
c. Germany - France: 2 – 2
d. Uruguay - Italy: 6 – 6
e. Argentina - Australia: 3 - 1

The summary would provide with the following information:
1. Uruguay 6 - Italy 6
2. Spain 10 - Brazil 2
3. Mexico 0 - Canada 5
4. Argentina 3 - Australia 1
5. Germany 2 - France 2
```

### Dictionary

During the investigation or workshops, normally I'd like to discover _vocabulary_ and better understanding of
_actions_ we can have in this system scope.

Now assuming it is something like:

| Business name                  | Tech name   | Building block        | Details                                                                                                                                               |
|--------------------------------|-------------|-----------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------|
|                                | Day         | Value object          | Representation of day in the scope of world cup.                                                                                                      |
| Football World Cup Score Board | ScoreBoard  | Aggregate root entity | An aggregate of multiple games within one day. Team can have only one game within one _day_.                                                          |
| Game                           | Game        | Entity                | It is a football game / match representation. It must be scheduled for concrete _day_, and two _teams_ must be known for proper _role_ (home or away) |
|                                | Game Status | Enum                  | _Scheduled, started, finished_ - internal thing, that helps to keep logic valid                                                                       |
| Score                          | Score       | Value object          | A representation of current / past game result, as non negative combination of home and away teams.                                                   |
| Team                           | Team        | Entity                | A representation of team, just name for now.                                                                                                          |
|                                | TeamType    | Enum                  | An information within a _game_ - what each _team_ type is: _home_ or _away_.                                                                          |

I've discovered (simulating discovery) the following actions:

- `Scheduling` - a process of planning `Game` which not started yet ()
- `Starting a game` - a process of starting a _scheduled game_
- `Finishing a game` - a process of finishing a _started game_ - that should remove entity from broadcasting
- `Broadcasting` - our main logic, displaying the collected data in expected way, within a `Day`

**Attention:**
"_Get a summary of games by total score. Those games with the same total score
will be returned ordered by the most recently added to our system._"

**For me it means that on draw, game was added later has a precedence.**

### Architecture

#### Logic

For app logic, I'd prefer to use some building blocks
from [tactical DDD](https://thedomaindrivendesign.io/what-is-tactical-design/) and focus on encapsulating business rules
within proper objects, with TDD in mind it can be tested easily and written with SOLID principles in mind.

My main assumption is that the only way to interact with this module (whole app) is just from the _Facade_, which
should be an _entry point_ e.g. when we use it as API endpoint and user interacts with it
is should accept just primitive types and transform it to proper _domain object_ such: _Value Objects_, _Entities_ etc.

Layer below I've introduced Domain Model, something like aggregate root in DDD - it means, the only way to manipulate
the data is through this object directly (all actions section below).

#### Projection

As _projection_ and _write_ logic seems to be quite close each other, it make sense to re-use the same object (write
models)
in sake of projection, however I've hidden it behind `PresenterInterface` to do whatever manipulations we want and safe
time a little.

In this example, we are using hardcoded data, so ordering is more challenging—but it might be easily replaced by
some projection from sql (by raw sql query) and then it might be straight forward.
