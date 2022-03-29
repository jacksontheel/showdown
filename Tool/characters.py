"""
A simple tool for generating the INSERT statements for the site.
"""

import random

characters = [
    "Tony the Tiger",
    "Count Chockula",
    "Captain Crunch",
    "Mrs. Butterworth",
    "Pillsbury Doughboy",
    "Ronald McDonald",
    "Garfield",
    "Jon Arbuckle",
    "Geico Gecko",
    "Gandalf",
    "Bilbo Baggins",
    "Batman",
    "E.T",
    "Shrek",
    "Spider-Man",
    "Sherlock Holmes",
    "Holden Caulfield",
    "Hannibal Lector",
    "Jay Gatsby",
    "Mario",
    "Luigi",
    "Sonic The Hedgehog",
    "Scooby Doo",
    "Scrappy Doo",
    "Achilles",
    "Mickey Mouse",
    "Donald Duck",
    "Bugs Bunny",
    "Daffy Duck",
    "James Bond",
    "Winnie the Pooh",
    "Peter Pan",
    "Darth Vader",
    "Luke Skywalker",
    "Bart Simpson",
    "Marge Simpson",
    "Margaret Thatcher",
    "Tom Hanks",
    "Harry Houdini",
    "Queen Elizabeth",
    "Michael Phelps",
    "OJ Simpson",
    "John F Kennedy",
    "George Washington",
    "Abraham Lincoln",
    "Franklin Delano Roosevelt",
    "Johnny Depp",
    "Jesus Christ",
    "Karl Marx",
    "Everything Bagel",
]

for c in characters:
    print(f"INSERT INTO contestant(username) VALUES ('{c}');")

startO = 1
matches = []
for c in characters:
    for o in characters[startO:]:
        matches.append([c, o])
    startO += 1

random.shuffle(matches)

matchId = 1
for m in matches:
    print(f"INSERT INTO fight VALUES (DEFAULT);")
    print(f"INSERT INTO fightcontestant (fightid, contestant) VALUES ({matchId}, '{m[0]}');")
    print(f"INSERT INTO fightcontestant (fightid, contestant) VALUES ({matchId}, '{m[1]}');")
    matchId += 1
