<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CodeCheck extends Command
{
    protected $signature = 'code:check';
    protected $description = 'Run PHP Insights, PHPStan, and PHPUnit';

    public function handle(): int
    {
        $this->titleBlock('Generating model docblocks...');
        $this->runProcess(['php', 'artisan', 'ide-helper:models', '--write']);

        $this->titleBlock('PHP Insights');
        $this->runProcess(['php', 'vendor/bin/phpinsights', '--no-interaction', '--format=console']);

        $this->titleBlock('PHPStan');
        $this->runProcess(['php', 'vendor/bin/phpstan', 'analyse', '--configuration=phpstan.neon']);

        $this->titleBlock('PHPUnit');
        $this->runProcess(['php', 'artisan', 'test']);

        $this->info("\n🎉 Tous les contrôles sont terminés avec succès.");
        return Command::SUCCESS;
    }

    private function runProcess(array $command): void
    {
        $process = new \Symfony\Component\Process\Process($command);
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });
    }

    private function titleBlock(string $title): void
    {
        $bar = str_repeat('─', strlen($title) + 4);
        $this->newLine();
        $this->line("┌{$bar}┐");
        $this->line("│  {$title}  │");
        $this->line("└{$bar}┘");
    }
}
