<?php
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('src'));
foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $path = $file->getPathname();
        $content = file_get_contents($path);
        
        if (strpos($content, 'namespace ') !== false) {
            continue;
        }

        // Determine namespace
        $relPath = substr($path, 4); // remove 'src\'
        $dir = dirname($relPath);
        $ns = 'App';
        if ($dir !== '.') {
            $ns .= '\\' . str_replace('/', '\\', $dir);
        }

        // Remove require_once
        $content = preg_replace('/^require_once.*$/m', '', $content);

        // Uses to add
        $uses = [
            'use App\Position;',
            'use App\Move;',
            'use App\Board;',
            'use App\Game;',
            'use App\Piece\Piece;',
            'use App\Piece\Pawn;',
            'use App\Piece\Rook;',
            'use App\Piece\Knight;',
            'use App\Piece\Bishop;',
            'use App\Piece\Queen;',
            'use App\Piece\King;',
            'use App\Enum\PieceColor;',
            'use App\Enum\PieceType;',
            'use App\Contract\InterfaceBoard;',
            'use App\Contract\Renderable;',
            'use App\Factory\PieceFactory;',
            'use App\Exception\ChessException;',
            'use App\Exception\InvalidBoardSizeException;',
            'use App\Exception\InvalidMoveException;',
            'use App\Exception\InvalidPieceTypeException;',
            'use App\Exception\NoPieceException;',
            'use App\Exception\OccupiedByAllyException;',
            'use App\Exception\SameTileException;',
            'use App\Exception\WrongTurnException;'
        ];

        // Insert namespace and uses after <?php
        $replacement = "<?php\nnamespace $ns;\n\n";
        
        $lines = explode("\n", $content);
        $newLines = [];
        $inserted = false;
        foreach ($lines as $line) {
            if (trim($line) === '<?php') {
                $newLines[] = "<?php\nnamespace $ns;\n";
                // Only add uses that are actually used in this file (rudimentary check)
                foreach ($uses as $use) {
                    $className = substr($use, strrpos($use, '\\') + 1, -1);
                    if (strpos($content, $className) !== false) {
                        // Don't add use if the class is in the same namespace
                        $useNs = substr($use, 4, strrpos($use, '\\') - 4);
                        if ($useNs !== $ns) {
                            $newLines[] = $use;
                        }
                    }
                }
                $newLines[] = "";
                $inserted = true;
            } else {
                // remove extra empty lines left by require_once removal
                if (trim($line) === '' && !$inserted) continue;
                $newLines[] = $line;
            }
        }
        
        $newContent = implode("\n", $newLines);
        // Clean up multiple empty lines
        $newContent = preg_replace("/\n{3,}/", "\n\n", $newContent);
        
        file_put_contents($path, $newContent);
    }
}
