#!/usr/bin/perl
use Cwd 'abs_path';
$realpath = abs_path();

exec("$realpath/bin/phing -f $realpath/build.xml $ARGV[0]");
