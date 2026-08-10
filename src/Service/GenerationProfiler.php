<?php

/**
 * DISCLAIMER.
 *
 * Do not edit or add to this file if you wish to upgrade Gally to newer versions in the future.
 *
 * @author    Gally Team <elasticsuite@smile.fr>
 * @copyright 2022-present Smile
 * @license   Open Software License v. 3.0 (OSL-3.0)
 */

declare(strict_types=1);

namespace Gally\SampleData\Service;

class GenerationProfiler
{
    /** @var array<string, array{start: float, total: float, count: int}> */
    private static array $timers = [];

    public function start(string $section): void
    {
        self::$timers[$section] ??= ['start' => 0.0, 'total' => 0.0, 'count' => 0];
        self::$timers[$section]['start'] = hrtime(true);
    }

    public function stop(string $section): void
    {
        if (!isset(self::$timers[$section])) {
            return;
        }

        $elapsed = hrtime(true) - self::$timers[$section]['start'];
        self::$timers[$section]['total'] += $elapsed;
        ++self::$timers[$section]['count'];
    }

    public function reset(): void
    {
        self::$timers = [];
    }

    /**
     * @return array<string, array{total_ms: float, count: int, avg_ms: float, percent: float}>
     */
    public function getReport(): array
    {
        $grandTotal = array_sum(array_column(self::$timers, 'total'));
        $report = [];

        foreach (self::$timers as $section => $data) {
            $totalMs = $data['total'] / 1_000_000;
            $count = $data['count'];
            $report[$section] = [
                'total_ms' => round($totalMs, 2),
                'count' => $count,
                'avg_ms' => $count > 0 ? round($totalMs / $count, 3) : 0.0,
                'percent' => $grandTotal > 0 ? round($data['total'] / $grandTotal * 100, 1) : 0.0,
            ];
        }

        arsort($report);

        return $report;
    }

    public function dump(\Symfony\Component\Console\Output\OutputInterface $output, string $context = ''): void
    {
        if (!$output->isVerbose()) {
            return;
        }

        $report = $this->getReport();
        $title = $context ? "Profiling — {$context}" : 'Profiling';
        $output->writeln('');
        $output->writeln("<comment>┌─ {$title}</comment>\n<comment>│</comment>");

        foreach ($report as $section => $data) {
            $bar = str_repeat('█', (int) ($data['percent'] / 5));
            $output->writeln(\sprintf(
                '<comment>│</comment>  %-40s %8.3f s  %5.1f%%  ×%-7d  avg %7.3f s  %s',
                $section,
                $data['total_ms'] / 1000,
                $data['percent'],
                $data['count'],
                $data['avg_ms'] / 1000,
                $bar,
            ));
        }

        $output->writeln("<comment>│</comment>\n<comment>└────────────────────────────────────────────────────────────────────────────────────────────────</comment>");
        $output->writeln('');
    }
}
