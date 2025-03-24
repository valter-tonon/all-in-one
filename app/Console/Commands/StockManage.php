<?php

namespace App\Console\Commands;

use App\Application\DTOs\StockDTO;
use App\Application\Services\StockService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class StockManage extends Command
{
    /**
     * O nome e a assinatura do comando.
     *
     * @var string
     */
    protected $signature = 'stock:manage {action} {--id=} {--name=} {--quantity=} {--price=} {--description=} {--category=}';

    /**
     * A descrição do comando.
     *
     * @var string
     */
    protected $description = 'Gerencia o estoque (add, update, remove, list, low-stock, out-of-stock)';

    /**
     * Executa o comando.
     */
    public function handle(StockService $stockService)
    {
        $action = $this->argument('action');
        
        try {
            switch ($action) {
                case 'add':
                    return $this->addStock($stockService);
                case 'update':
                    return $this->updateStock($stockService);
                case 'remove':
                    return $this->removeStock($stockService);
                case 'list':
                    return $this->listStock($stockService);
                case 'low-stock':
                    return $this->lowStock($stockService);
                case 'out-of-stock':
                    return $this->outOfStock($stockService);
                default:
                    $this->error("Ação inválida. Use: add, update, remove, list, low-stock, out-of-stock");
                    return Command::FAILURE;
            }
        } catch (\Exception $e) {
            $this->error("Erro ao gerenciar estoque: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
    
    private function addStock(StockService $stockService)
    {
        $name = $this->option('name');
        if (!$name) {
            $name = $this->ask('Nome do produto');
        }
        
        $quantity = $this->option('quantity');
        if (!$quantity) {
            $quantity = $this->ask('Quantidade');
        }
        
        $price = $this->option('price');
        if (!$price) {
            $price = $this->ask('Preço');
        }
        
        $description = $this->option('description');
        if (!$description) {
            $description = $this->ask('Descrição (opcional)', '');
        }
        
        $category = $this->option('category');
        if (!$category) {
            $category = $this->ask('Categoria (opcional)', '');
        }
        
        $sku = Str::upper(Str::substr(Str::slug($name), 0, 3) . '-' . rand(1000, 9999));
        
        $dto = new StockDTO(
            name: $name,
            quantity: (int) $quantity,
            price: (float) $price,
            description: $description,
            sku: $sku,
            category: $category
        );
        
        $stock = $stockService->create($dto);
        
        $this->info("Produto adicionado com sucesso!");
        $this->table(
            ['ID', 'Nome', 'SKU', 'Quantidade', 'Preço', 'Categoria', 'Status'],
            [[$stock->id, $stock->name, $stock->sku, $stock->quantity, $stock->price, $stock->category, $stock->status]]
        );
        
        return Command::SUCCESS;
    }
    
    private function updateStock(StockService $stockService)
    {
        $id = $this->option('id');
        if (!$id) {
            $id = $this->ask('ID do produto');
        }
        
        $stock = $stockService->findById($id);
        
        $name = $this->option('name') ?? $stock->name;
        $quantity = $this->option('quantity') ?? $stock->quantity;
        $price = $this->option('price') ?? $stock->price;
        $description = $this->option('description') ?? $stock->description;
        $category = $this->option('category') ?? $stock->category;
        
        $dto = new StockDTO(
            name: $name,
            quantity: (int) $quantity,
            price: (float) $price,
            description: $description,
            sku: $stock->sku,
            category: $category
        );
        
        $updatedStock = $stockService->update($id, $dto);
        
        $this->info("Produto atualizado com sucesso!");
        $this->table(
            ['ID', 'Nome', 'SKU', 'Quantidade', 'Preço', 'Categoria', 'Status'],
            [[$updatedStock->id, $updatedStock->name, $updatedStock->sku, $updatedStock->quantity, $updatedStock->price, $updatedStock->category, $updatedStock->status]]
        );
        
        return Command::SUCCESS;
    }
    
    private function removeStock(StockService $stockService)
    {
        $id = $this->option('id');
        if (!$id) {
            $id = $this->ask('ID do produto');
        }
        
        if ($this->confirm("Tem certeza que deseja remover o produto ID $id?")) {
            $stockService->delete($id);
            $this->info("Produto removido com sucesso!");
        } else {
            $this->info("Operação cancelada.");
        }
        
        return Command::SUCCESS;
    }
    
    private function listStock(StockService $stockService)
    {
        $stocks = $stockService->getAll();
        
        if ($stocks->isEmpty()) {
            $this->warn("Nenhum produto encontrado.");
            return Command::SUCCESS;
        }
        
        $this->info("Total de produtos: " . $stocks->count());
        
        $tableData = $stocks->map(function ($stock) {
            return [
                $stock->id,
                $stock->name,
                $stock->sku,
                $stock->quantity,
                $stock->price,
                $stock->category,
                $stock->status
            ];
        })->toArray();
        
        $this->table(
            ['ID', 'Nome', 'SKU', 'Quantidade', 'Preço', 'Categoria', 'Status'],
            $tableData
        );
        
        return Command::SUCCESS;
    }
    
    private function lowStock(StockService $stockService)
    {
        $stocks = $stockService->getLowStock();
        
        if ($stocks->isEmpty()) {
            $this->info("Não há produtos com estoque baixo.");
            return Command::SUCCESS;
        }
        
        $this->warn("Produtos com estoque baixo: " . $stocks->count());
        
        $tableData = $stocks->map(function ($stock) {
            return [
                $stock->id,
                $stock->name,
                $stock->sku,
                $stock->quantity,
                $stock->price,
                $stock->category,
                $stock->status
            ];
        })->toArray();
        
        $this->table(
            ['ID', 'Nome', 'SKU', 'Quantidade', 'Preço', 'Categoria', 'Status'],
            $tableData
        );
        
        return Command::SUCCESS;
    }
    
    private function outOfStock(StockService $stockService)
    {
        $stocks = $stockService->getOutOfStock();
        
        if ($stocks->isEmpty()) {
            $this->info("Não há produtos sem estoque.");
            return Command::SUCCESS;
        }
        
        $this->error("Produtos sem estoque: " . $stocks->count());
        
        $tableData = $stocks->map(function ($stock) {
            return [
                $stock->id,
                $stock->name,
                $stock->sku,
                $stock->quantity,
                $stock->price,
                $stock->category,
                $stock->status
            ];
        })->toArray();
        
        $this->table(
            ['ID', 'Nome', 'SKU', 'Quantidade', 'Preço', 'Categoria', 'Status'],
            $tableData
        );
        
        return Command::SUCCESS;
    }
} 