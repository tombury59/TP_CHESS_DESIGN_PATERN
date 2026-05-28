<?php
require_once __DIR__ . '/vendor/autoload.php';
use App\Position;
use App\Move;
use App\Game;
use App\Enum\PieceColor;
use App\Enum\PieceType;
use App\Exception\ChessException;
use App\Exception\InvalidBoardSizeException;
use App\Exception\InvalidMoveException;
use App\Exception\InvalidPieceTypeException;
use App\Exception\NoPieceException;
use App\Exception\OccupiedByAllyException;
use App\Exception\SameTileException;
use App\Exception\WrongTurnException;


/**
 * Joue une série de coups.
 *
 * @param Game $game
 * @param array $coups
 * @return void
 */
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

/**
 * Orchestre un scénario de test pour éviter la duplication de code.
 */
function executerScenario(string $nom, array $coups, ?array $coupFinal = null, ?callable $callbackIntermediaire = null): void
{
    echo "\n=== SCENARIO : $nom ===\n";
    
    $game = new Game();
    $game->start();
    echo $game->getBoard()->render() . "\n";

    try {
        jouerCoups($game, $coups);

        if ($callbackIntermediaire) {
            $callbackIntermediaire($game);
        }

        if ($coupFinal) {
            echo "--- Avant action finale ---\n";
            echo $game->getBoard()->render() . "\n";

            $game->play(new Move(new Position($coupFinal[0][0], $coupFinal[0][1]), new Position($coupFinal[1][0], $coupFinal[1][1])));

            echo "--- Après action finale ---\n";
            echo $game->getBoard()->render() . "\n";
        }
    } catch (ChessException $e) {
        echo "Erreur règle : " . $e->getMessage() . "\n";
    } catch (Exception $e) {
        echo "Erreur système : " . $e->getMessage() . "\n";
    }
}

// 1. Petit roque
function scenarioPetitRoque(): void
{
    executerScenario("Petit Roque", [
        [[6,4],[4,4]], [[1,0],[2,0]], // e2->e4, a7->a6
        [[7,5],[4,2]], [[1,1],[2,1]], // f1->c4, b7->b6
        [[7,6],[5,5]], [[1,2],[2,2]], // g1->f3, c7->c6
    ], [[7,4], [7,6]]); // Final: e1 -> g1
}

// 2. Mat du berger
function scenarioMatDuBerger(): void
{
    executerScenario("Mat du berger", [
        [[6,4],[4,4]], [[1,0],[2,0]], // e2->e4, a7->a5
        [[7,5],[4,2]], [[2,0],[3,0]], // f1->c4, a5->a4
        [[7,3],[5,5]], [[0,1],[2,2]], // d1->h5, b8->c6
    ], [[1,7], [2,7]], function($game) { // Final: h7 -> h6
        // check si le roi noir est en echec
        echo "Check ? " . ($game->isCheck($game->getCurrentPlayer()) ? "true" : "false") . "\n";
        
        $game->play(new Move(new Position(5,5), new Position(1,5)));
        
        echo "Check ? " . ($game->isCheck($game->getCurrentPlayer()) ? "true" : "false") . "\n";
        echo "Tour : " . $game->getCurrentPlayer()->name . "\n";
    });
}

// 3. Grand roque
function scenarioGrandRoque(): void
{
    executerScenario("Grand Roque blanc", [
        [[6,3],[4,3]], [[1,0],[2,0]], // d2->d4, a7->a6
        [[6,2],[4,2]], [[1,1],[2,1]], // c2->c4, b7->b6
        [[7,1],[5,2]], [[1,2],[2,2]], // b1->c3, c7->c6
        [[7,2],[5,4]], [[1,3],[2,3]], // c1->e3, d7->d6
        [[7,3],[6,3]], [[1,4],[2,4]], // d1->d2, e7->e6
    ], [[7,4], [7,2]]); // Final: e1 -> c1
}

// 4. Capture
function scenarioCapture(): void
{
    executerScenario("Capture", [
        [[6,4],[4,4]], [[1,0],[2,0]], // e2->e4, a7->a6
        [[7,5],[4,2]], [[2,0],[3,0]], // f1->c4, a5->a4
        [[7,3],[5,5]], [[0,1],[2,2]], // d1->h5, b8->c6
    ], [[5,5], [1,5]], function($game) {
        
    });
}

scenarioPetitRoque();
// scenarioMatDuBerger();
// scenarioGrandRoque();
// scenarioCapture();