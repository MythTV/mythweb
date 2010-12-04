<?php
/**
 * Run a command on a frontend
 *
 *
 * @package     MythWeb
 * @subpackage  Remote
 *
/**/

    $frontend = $Frontends[$Path[2]];

    if (!isset($frontend)) {
        header('HTTP/1.0 404 Not Found', true, 404);
        die(t('Unknown frontend'));
    }

    $action   = $Path[3];
    $parms    = array_slice($Path, 4);

    switch ($action) {
        case 'SendKey':
            if (!$frontend->send_key($parms[0]))
                header('HTTP/1.0 400 Bad Request', true, 400);
            break;

        case 'PlayProgram':
            if (!$frontend->play_program($parms[0], $parms[1]))
                header('HTTP/1.0 400 Bad Request', true, 400);
            break;

        case 'JumpTo':
            if (!$frontend->send_jump($parms[0]))
                header('HTTP/1.0 400 Bad Request', true, 400);
            break;

        case 'GetLocation':
            echo json_encode($frontend->query_location());
            break;

        case 'GetJumppoints':
            echo json_encode($frontend->get_jump_points());
            break;

        case 'Query':
            echo json_encode($frontend->query($parms[0]));
            break;

        default:
            header('HTTP/1.0 501 Not Implemented', true, 501);
            die(t('Unknown action'));
    }
