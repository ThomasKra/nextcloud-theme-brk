<?php

declare(strict_types=1);

/**
 * BRK theme for Nextcloud
 *
 * @copyright Copyright (C) 2023  Magnus Walbeck <mw@mwalbeck.org>
 *
 * @author Magnus Walbeck <mw@mwalbeck.org>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\Brk\Migration;

use OCP\IConfig;
use OCP\IDBConnection;
use OCP\DB\QueryBuilder\IQueryBuilder;
use OCP\Migration\IOutput;
use OCP\Migration\IRepairStep;

class UninstallCleanup implements IRepairStep
{
    /** @var IDBConnection */
    private $db;

    /** @var IConfig */
    private $config;

    public function __construct(IDBConnection $db, IConfig $config)
    {
        $this->db = $db;
        $this->config = $config;
    }

    public function getName(): string
    {
        return "Aufheben der Erzwingung des BRK Themes.";
    }

    public function run(IOutput $output): void
    {
        $currentEnforcedTheme = $this->config->getSystemValue("enforce_theme", "");

        // Aufheben der Erzwingung des BRK Themes
        if ($currentEnforcedTheme === Application::APP_NAME) {
            $this->config->setSystemValue("enforce_theme", "");
        }
    }
}
