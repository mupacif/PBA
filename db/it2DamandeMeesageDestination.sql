CREATE Table Demandes(
_ID INTEGER NOT NULL,
 idUser INTEGER NOT NULL, 
 description TEXT NOT NULL,
 poids TEXT, 
 date VARCHAR(255) NOT NULL,
 PRIMARY KEY(_ID),
 FOREIGN KEY (idUser) references User( _ID) ON DELETE CASCADE);
 
 
 CREATE Table Message(
_ID INTEGER NOT NULL,
 idUser INTEGER NOT NULL, 
 content TEXT NOT NULL,
 date VARCHAR(255) NOT NULL,
 PRIMARY KEY(_ID),
 FOREIGN KEY (idUser) references User( _ID) ON DELETE CASCADE);
 
 
  CREATE Table Destination(
_ID INTEGER NOT NULL,
 idUser INTEGER NOT NULL, 
 destination TEXT NOT NULL,
 tailleDispo TEXT NOT NULL,
 date VARCHAR(255) NOT NULL,
 PRIMARY KEY(_ID),
 FOREIGN KEY (idUser) references User( _ID) ON DELETE CASCADE);