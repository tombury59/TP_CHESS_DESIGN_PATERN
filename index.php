<?php
require_once __DIR__ . '/src/Contract/Renderable.php';
require_once __DIR__ . '/src/Enum/PieceColor.php';
require_once __DIR__ . '/src/Enum/PieceType.php';
require_once __DIR__ . '/src/Position.php';
require_once __DIR__ . '/src/Move.php';
require_once __DIR__ . '/src/Exception/ChessException.php';
require_once __DIR__ . '/src/Exception/InvalidMoveException.php';
require_once __DIR__ . '/src/Exception/NoPieceException.php';
require_once __DIR__ . '/src/Exception/WrongTurnException.php';
require_once __DIR__ . '/src/Exception/OccupiedByAllyException.php';
require_once __DIR__ . '/src/Board.php';
require_once __DIR__ . '/src/Piece/Piece.php';
require_once __DIR__ . '/src/Piece/King.php';
require_once __DIR__ . '/src/Piece/Queen.php';
require_once __DIR__ . '/src/Piece/Rook.php';
require_once __DIR__ . '/src/Piece/Bishop.php';
require_once __DIR__ . '/src/Piece/Knight.php';
require_once __DIR__ . '/src/Piece/Pawn.php';
require_once __DIR__ . '/src/Factory/PieceFactory.php';
require_once __DIR__ . '/src/Game.php';

function jouerCoups(Game $game, array $coups): void
{
    foreach ($coups as $coup) {
        $game->play(
            new Move(
                new Position($coup[0][0], $coup[0][1]),
                new Position($coup[1][0], $coup[1][1])
            )
        );
    }
}

// Petit roque
function scenarioPetitRoque(): void
{
    echo "\n=== SCENARIO 1 : Petit Roque blanc ===\n";

    $game = new Game();
    $game->start();

    echo $game->getBoard()->render() . "\n";

    try {

        $coups = [

            [[6,4],[4,4]], // e2 -> e4
            [[1,0],[2,0]], // a7 -> a6

            [[7,5],[4,2]], // f1 -> c4
            [[1,1],[2,1]], // b7 -> b6

            [[7,6],[5,5]], // g1 -> f3
            [[1,2],[2,2]], // c7 -> c6

        ];

        jouerCoups($game, $coups);

        echo "--- Avant le roque ---\n";
        echo $game->getBoard()->render() . "\n";

        // Roque : e1 -> g1
        $game->play(
            new Move(
                new Position(7,4),
                new Position(7,6)
            )
        );

        echo "--- Après le roque ---\n";
        echo $game->getBoard()->render() . "\n";

        echo "Roi 'K' en (7:6), Tour 'R' en (7:5)\n";

    } catch (ChessException $e) {

        echo "Erreur règle : " . $e->getMessage() . "\n";

    } catch (Exception $e) {

        echo "Erreur système : " . $e->getMessage() . "\n";
    }
}

// Mat du berger
function scenarioMatDuBerger(): void
{
    echo "\n=== SCENARIO 2 : Mat du berger ===\n";

    $game = new Game();
    $game->start();

    echo $game->getBoard()->render();
    echo "Tour : " . $game->getCurrentPlayer()->name . "\n\n";

    try {

        $coups = [

            [[6,4],[4,4]], // e2 -> e4
            [[1,0],[2,0]], // a7 -> a5

            [[7,5],[4,2]], // f1 -> c4
            [[2,0],[3,0]], // a5 -> a4

            [[7,3],[5,5]], // d1 -> h5
            [[0,1],[2,2]], // b8 -> c6

        ];

        jouerCoups($game, $coups);

        echo "Check ? "
            . ($game->isCheck($game->getCurrentPlayer()) ? "true" : "false")
            . "\n";

        // h5 -> f7
        $game->play(
            new Move(
                new Position(5,5),
                new Position(1,5)
            )
        );

        echo "Check ? "
            . ($game->isCheck($game->getCurrentPlayer()) ? "true" : "false")
            . "\n";

        echo $game->getBoard()->render();
        echo "Tour : " . $game->getCurrentPlayer()->name . "\n\n";

        // h7 -> h6
        $game->play(
            new Move(
                new Position(1,7),
                new Position(2,7)
            )
        );

    } catch (ChessException $e) {

        echo "Error : " . $e->getMessage() . "\n";
    }
}

// Grand roque
function scenarioGrandRoque(): void
{
    echo "\n=== SCENARIO 3 : Grand Roque blanc ===\n";

    $game = new Game();
    $game->start();

    echo $game->getBoard()->render() . "\n";

    try {

        $coups = [

            [[6,3],[4,3]], // d2 -> d4
            [[1,0],[2,0]], // a7 -> a6

            [[6,2],[4,2]], // c2 -> c4
            [[1,1],[2,1]], // b7 -> b6

            [[7,1],[5,2]], // b1 -> c3
            [[1,2],[2,2]], // c7 -> c6

            [[7,2],[5,4]], // c1 -> e3
            [[1,3],[2,3]], // d7 -> d6

            [[7,3],[6,3]], // d1 -> d2
            [[1,4],[2,4]], // e7 -> e6

        ];

        jouerCoups($game, $coups);

        echo "--- Avant le grand roque ---\n";
        echo $game->getBoard()->render() . "\n";

        // Grand roque : e1 -> c1
        $game->play(
            new Move(
                new Position(7,4),
                new Position(7,2)
            )
        );

        echo "--- Après le grand roque ---\n";
        echo $game->getBoard()->render() . "\n";

        echo "Roi 'K' en (7:2), Tour 'R' en (7:3)\n";

    } catch (ChessException $e) {

        echo "Erreur règle : " . $e->getMessage() . "\n";

    } catch (Exception $e) {

        echo "Erreur système : " . $e->getMessage() . "\n";
    }
}

//scenarioPetitRoque();
//scenarioMatDuBerger();
scenarioGrandRoque();