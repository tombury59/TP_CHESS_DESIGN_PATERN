# Jeu d'échecs en PHP - Design Patterns

Ce projet est une implémentation d'un jeu d'échecs en PHP orienté objet. Il a été conçu dans le cadre d'un TP pour mettre en pratique différents concepts de programmation orientée objet (POO) et des **Design Patterns** tels que la **Factory** (pour la création des pièces) et potentiellement d'autres.

## Fonctionnalités

- Création dynamique d'un plateau de jeu d'échecs.
- Gestion des pièces via une fabrique (`PieceFactory`).
- Gestion des mouvements avec vérification des chemins (détection d'obstacles).
- Détection des différents types de mouvements (validité selon la pièce).
- Gestion des exceptions métiers (`InvalidMoveException`, `WrongTurnException`, `OccupiedByAllyException`, etc.).
- Affichage du plateau dans le terminal avec des couleurs de fond (rendu ASCII).

## Structure du projet

- `src/Board.php` : Classe représentant le plateau de jeu.
- `src/Game.php` : Moteur de jeu gérant les tours, les joueurs et l'état.
- `src/Position.php` : Représente des coordonnées (ligne, colonne) sur le plateau.
- `src/Move.php` : Représente un mouvement d'une position à une autre.
- `src/Piece/` : Contient la classe abstraite `Piece` et ses implémentations (`King`, `Queen`, `Rook`, `Knight`, `Bishop`, `Pawn`).
- `src/Factory/PieceFactory.php` : Design Pattern Factory pour l'instanciation des pièces.
- `src/Exception/` : Ensemble des exceptions spécifiques au jeu.
- `src/Enum/` : Contient les énumérations comme `PieceColor` ou `PieceType`.
- `src/Contract/` : Interfaces (ex: `InterfaceBoard`, `Renderable`).

## Comment lancer le projet

Pour tester le jeu, vous pouvez lancer le fichier `index.php` (qui se charge d'instancier un `Game` et de le lancer) avec la commande suivante dans un terminal :

```bash
php index.php
```

## Concepts Abordés

1. **Encapsulation** : Protection de l'état interne des objets (ex: `pieces` dans `Board`).
2. **Héritage & Polymorphisme** : Utilisation d'une classe de base `Piece` redéfinissant la logique de mouvement pour chaque sous-classe.
3. **Interfaces** : Séparation des contrats et des implémentations (`InterfaceBoard`).
4. **Exceptions Personnalisées** : Clarification de la gestion d'erreurs (mouvement interdit, case occupée, etc.).
5. **Design Pattern Factory** : Délégation de l'instanciation complexe des pièces.

### Classes principales

✅ Position

    ✅ __construct()
    ✅ getRow()
    ✅ getColumn()
    ✅ equals()
    ✅ toKey()
    ✅ fromKey()

✅ Move

    ✅ __construct()
    ✅ getFrom()
    ✅ getTo()
    
✅ Board

    ✅ placePiece()
    ✅ getPieceAt()
    ✅ hasPieceAt()
    ✅ removePieceAt()
    ✅ movePiece()
    ✅ isPathClear()
    ✅ getPieces()
    ✅ getKingPosition()
    ✅ render()

✅ Game

    ✅ __construct()
    ✅ start()
    ✅ getBoard()
    ✅ getCurrentPlayer()
    ✅ play()
    ✅ isCheck()
    ✅ setupPieces()
    ✅ switchPlayer()

### Pièces

✅ Piece

    ✅ __construct()
    ✅ getColor()
    ✅ getPosition()
    ✅ setPosition()
    ✅ getType()
    ✅ render()
    ✅ canMove()
    ✅ isValidMovementShape()
    ✅ canCapture()

✅ King

    ✅ isValidMovementShape()

✅ Queen

    ✅ isValidMovementShape()

✅ Rook

    ✅ isValidMovementShape()

✅ Bishop

    ✅ isValidMovementShape()

✅ Knight

    ✅ isValidMovementShape()

✅ Pawn

    ✅ isValidMovementShape()

### Factory

✅ PieceFactory
    ✅ create()

### Interface / Enums

✅ Renderable

    ✅ render()

✅ PieceColor

    ✅ WHITE
    ✅ BLACK
    ✅ opposite()

✅ PieceType

    ✅ KING
    ✅ QUEEN
    ✅ ROOK
    ✅ BISHOP
    ✅ KNIGHT
    ✅ PAWN

### Exceptions

✅ ChessException
✅ InvalidMoveException
✅ NoPieceException
✅ WrongTurnException
✅ OccupiedByAllyException

### Bonus

✅ Roque
❌ Promotion du pion
❌ Prise en passant
✅ Interdiction de mettre son propre roi en échec
❌ Échec et mat
❌ Pat
❌ Historique complet des coups
❌ Tests automatisés
❌ Autre bonus : à préciser


