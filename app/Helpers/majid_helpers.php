<?php
include base_path('public/vendor/jdf/jdf.php');

function miladi_to_jalali($input_date, $show_time = false)
{
  if ($input_date) {
    $date = substr($input_date, 0, 10);
    $date = explode("-", $date);
    $date = gregorian_to_jalali($date[0], $date[1], $date[2], '/');
    $date = explode("/", $date);
    $date[0] = convertEnglishToPersian(sprintf("%02d", $date[0]));
    $date[1] = convertEnglishToPersian(sprintf("%02d", $date[1]));
    $date[2] = convertEnglishToPersian(sprintf("%02d", $date[2]));
    $date = implode("/", $date);
    if ($show_time) {
      $time = substr($input_date, 11, 15);
      $time = explode(':', $time);
      $time[0] = convertEnglishToPersian(sprintf("%02d", $time[0]));
      $time[1] = convertEnglishToPersian(sprintf("%02d", $time[1]));
      $time[2] = convertEnglishToPersian(sprintf("%02d", $time[2]));
      $time = implode(":", $time);

      return  $time . ' ' . $date;
    }
    return $date;
  } else {
    return 'بدون تاریخ';
  }
}


function convertPersianToEnglish($string)
{
  $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
  $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

  $output = str_replace($persian, $english, $string);
  return $output;
}

function convertEnglishToPersian($string)
{
  $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
  $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

  $output = str_replace($english, $persian, $string);
  return $output;
}

function jalali_to_miladi($input_date)
{

  $input_date = explode(" ", $input_date);
  // dd($input_date);
  $flag = count($input_date);
  if ($flag == 2) {
    $time = explode(":", $input_date[0]);
    $time[0] = sprintf("%02d", convertPersianToEnglish($time[0]));
    $time[1] = sprintf("%02d", convertPersianToEnglish($time[1]));
    $time[2] = sprintf("%02d", convertPersianToEnglish($time[2]));
    $time = implode(":", $time);
  }
  $date = ($flag == 2) ? explode("/", $input_date[1]) : explode("/", $input_date[0]);
  $date = jalali_to_gregorian($date[0], $date[1], $date[2], '-');
  $date = explode('-', $date);
  $date[0] = sprintf("%02d", $date[0]);
  $date[1] = sprintf("%02d", $date[1]);
  $date[2] = sprintf("%02d", $date[2]);
  $date = implode("-", $date);
  return ($flag == 2) ?  $date . ' ' . $time : $date;
}

// متد تبدیل تاریخ جلالی به میلادی بدون ورودی ساعت 
function jalali_to_miladi_date($input_date)
{
  $date = convertPersianToEnglish($input_date);
  $date = explode("/", $date);
  $date = jalali_to_gregorian($date[0], $date[1], $date[2], '-');
  $date = explode('-', $date);
  $date[0] = sprintf("%02d", $date[0]);
  $date[1] = sprintf("%02d", $date[1]);
  $date[2] = sprintf("%02d", $date[2]);
  $date = implode("-", $date);
  return  $date;
}

function ago_time($time_ago)
{
  $cur_time     = time();
  if (is_string($time_ago)) {
    $time_ago =  strtotime($time_ago);
  } else {
    $time_ago = $time_ago->timestamp;
  }
  $time_elapsed     = $cur_time - $time_ago;
  $seconds     = $time_elapsed;
  $minutes     = round($time_elapsed / 60);
  $hours         = round($time_elapsed / 3600);
  $days         = round($time_elapsed / 86400);
  $weeks         = round($time_elapsed / 604800);
  $months     = round($time_elapsed / 2600640);
  $years         = round($time_elapsed / 31207680);
  // Seconds
  if ($seconds <= 60) {
    return "$seconds ثانیه قبل";
  }
  //Minutes
  else if ($minutes <= 60) {
    if ($minutes == 1) {
      return "یک ماه پیش";
    } else {
      return "$minutes دقیقه قبل";
    }
  }
  //Hours
  else if ($hours <= 24) {
    if ($hours == 1) {
      return "یک ساعت قبل";
    } else {
      return "$hours ساعت قبل";
    }
  }
  //Days
  else if ($days <= 7) {
    if ($days == 1) {
      return "دیروز";
    } else {
      return "$days روز قبل";
    }
  }
  //Weeks
  else if ($weeks <= 4.3) {
    if ($weeks == 1) {
      return "یک هفته پیش";
    } else {
      return "$weeks هفته پیش";
    }
  }
  //Months
  else if ($months <= 12) {
    if ($months == 1) {
      return "یک ماه پیش";
    } else {
      return "$months ماه پیش";
    }
  }
  //Years
  else {
    if ($years == 1) {
      return "یک سال پیش";
    } else {
      return "$years سال پیش";
    }
  }
}

function generateRssFile()
{
  $title = 'وب سایت گفتمان سبز | goftemansabz News Website';
  $link = 'https://goftemansabz.ir';
  $description = 'goftemansabz News Website RSS Service';
  $language = 'fa-IR';
  $copyright = 'Copyright 2022, goftemansabz News Website';

  $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><rss/>');
  $xml->addAttribute('version', 2.0);
  $child = $xml->addChild('channel');
  $child->addChild("title", $title);
  $child->addChild("link", $link);
  $child->addChild("description", $description);
  $child->addChild("language", $language);
  $child->addChild("copyright", $copyright);
  $posts = DB::table('posts')->where('status', 1)->where('visibility', 1)->orderBy('created_at', 'desc')->take(10)->get();
  foreach ($posts as $post) {
    $item = $child->addChild("item");
    $item->addChild("title", $post->title);
    $item->addChild("link", $post->read_more_link);
    $item->addChild("description", $post->meta_description);
    $item->addChild("pubDate", $post->created_at);
  }

  $xml->asXml('rss.xml');
  // dd($xml);
}
