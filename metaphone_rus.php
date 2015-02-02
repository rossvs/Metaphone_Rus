<?php 
/*
	Function for Metaphone-like transformation of russian texts
	Based on Petr Kankowski code

	Copyright (C) 2014-2015, Vladislav Ross

	This library is free software; you can redistribute it and/or
	modify it under the terms of the GNU Lesser General Public
	License as published by the Free Software Foundation; either
	version 2.1 of the License, or (at your option) any later version.

	This library is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
	Lesser General Public License for more details.

	You should have received a copy of the GNU Lesser General Public
	License along with this library; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA

    E-mail: vladislav.ross@gmail.com
	URL: https://github.com/rossvs/metaphone_rus	
*/

function MetaPhoneRus($word, $surname = false)
{
	mb_internal_encoding('UTF-8');
	$word = mb_strtolower($word);
	$word = preg_replace('/[^оеаиуэюяпстрклмнбвгджзйфхцчшщыё]/u', '', $word);
	
	//Исключение повторяющихся символов
	$word = preg_replace('/(.)\\1+/u', '$1', $word);
		
	//Сжатие окончаний
	if($surname) 
	{		
		$endings = array(
			'овский' => '@',
			'евский' => '#',
			'овская' => '$',
			'евская' => '%',
			'иева' => '9',
			'еева' => '9',
			'ова' => '9',
			'ева' => '9',
			'ина' => '1',
			'иев' => '4',
			'еев' => '4',
			'нко' => '3',
			'ов' => '4',
			'ев' => '4',
			'ая' => '6',
			'ий' => '7',
			'ый' => '7',
			'ых' => '5',
			'их' => '5',
			'ин' => '8',
			'ик' => '2',
			'ек' => '2',
			'ук' => '0',
			'юк' => '0'
		);
	}
	else
	{
		
	}
	
	foreach($endings as $match => $replacement)
	{
		$count = 0;
		$word = preg_replace('/' . $match . '$/u', $replacement, $word, 1, $count);
		if($count > 0) break;
	}
	
	//Замена гласных
	$vowelsReplacement = array(
		'и' => array('йо', 'ио', 'йе', 'ие'),
		'a' => array('о', 'ы', 'я'),
		'и' => array('е', 'ё', 'э'),
		'у' => array('ю')		
	);
	
	foreach($vowelsReplacement as $replacement => $search)
	{
		$word = str_replace($search, $replacement, $word);
	}
	
	$word = preg_replace('/(.)\\1+/u', '$1', $word);
	
	//Оглушение согласных в слабой позиции (перед не сонорными согласными и на конце слов)
	$dullReplacement = array(
		'б' => 'п',
		'з' => 'с',
		'д' => 'т',
		'в' => 'ф',
		'г' => 'к'
	);
	
	foreach($dullReplacement as $search => $replace)
	{
		$word = preg_replace("/{$search}([псткбвгджзфхцчшщ])|{$search}()$/u", "{$replace}$1", $word);
	}
	
	//Исключение повторяющихся символов
	$word = preg_replace('/(.)\\1+/u', '$1', $word);		

	
	return $word;
}


