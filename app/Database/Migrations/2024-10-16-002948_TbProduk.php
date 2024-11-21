<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbProduk extends Migration
{
    public function up()
    {
         $this->forge->addField ([
            'produk_id' => [
                'type'             =>'INT',
                'constraint'       => '11',
                'usigned'          => 'TRUE',
               'auto_increment'    => 'TRUE',
             ],
             'nama_produk' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255',
             ],
             'harga' => [
                'type' => 'DECIMAL',
                'constrain' => '10,2',
             ],
             'stok' => [
                'type' => 'INT',
                'constrain' => '11',
             ],
            ]);
             $this->forge->addKey('produk_id', TRUE);
             $this->forge->createTable('TbProduk');
        }

    public function down()
    {
        $this->forge->dropTable('TbProduk');
    }
}
