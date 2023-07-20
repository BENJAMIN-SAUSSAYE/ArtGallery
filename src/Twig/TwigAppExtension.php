<?php

namespace App\Twig;

use DateTime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigAppExtension extends AbstractExtension
{
	public function getFilters(): array
	{
		return [
			new TwigFilter('date_diff', [$this, 'datediffFilter']),
		];
	}
	public function datediffFilter(DateTime $date, DateTime $now = null)
	{
		$now = $now ? $now : new DateTime();
		$diff = $date->diff($now);
		return $diff->format('%a');
	}

	/*
	public function formatPrice(float $number, int $decimals = 0, string $decPoint = '.', string $thousandsSep = ','): string
	{
		$price = number_format($number, $decimals, $decPoint, $thousandsSep);
		$price = '$' . $price;

		return $price;
	}
	*/
}
