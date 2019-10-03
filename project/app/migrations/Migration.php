<?php

namespace App\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;
use Phinx\Migration\AbstractMigration;

class Migration extends AbstractMigration {

    /** @var \Illuminate\Database\Capsule\Manager $capsule */
    public $capsule;

    /** @var \Illuminate\Database\Schema\Builder $schemaś */
    public $schema;

    public function init() {
        $this->capsule = new Capsule;
        $this->capsule->addConnection(CONFIG['DATABASE']);

        $this->capsule->bootEloquent();
        $this->capsule->setAsGlobal();
        $this->schema = $this->capsule->schema();
    }

}
