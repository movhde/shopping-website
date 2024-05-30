<?php

namespace App\Twig;

use Symfony\Component\VarDumper\VarDumper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
  public function getFunctions()
  {
    return [
      new TwigFunction('numberConvertor', [$this, 'convertEnglishToPersian']),
      new TwigFunction('englishToPersian', [$this, 'convertPersianToEnglish']),
    ];
  }

  public function convertEnglishToPersian(int $input)
  {
    $english = range(0, 10);
    $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '۱۰');
    $formattedNumber = number_format($input);
    return str_replace($english, $persian, $formattedNumber);
  }

  public function convertPersianToEnglish(int $input)
  {
    $english = range(0, 10);
    $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '۱۰');
    $formattedNumber = number_format($input);
    return str_replace($persian, $english, $formattedNumber);
  }
}
