<?php

# BENCODER v1.3 - Shen Cheng-Da (cdsheen at gmail.com)
# Project home: http://bbs.giga.net.tw/bencoder.php

if(!function_exists("readlink")) {
	function readlink() {
		die("Function readlink() cannot be found");
	}
}

if(!function_exists("symlink")) {
	function symlink() {
		die("Function symlink() cannot be found");
	}
}

if(!function_exists("bcompiler_write_header")) {
	function bcompiler_write_header() {
		die("Function bcompiler_write_header() cannot be found");
	}
}

if(!function_exists("bcompiler_write_file")) {
	function bcompiler_write_file() {
		die("Function bcompiler_write_file() cannot be found");
	}
}

if(!function_exists("bcompiler_write_footer")) {
	function bcompiler_write_footer() {
		die("Function bcompiler_write_footer() cannot be found");
	}
}

$title = 'BENCODER v1.3 - Encode your PHP script using bcompiler';

$help =	<<<HELP
$title

Usage: bencoder [-f] [-q] -o FILE    file1.php
       bencoder [-f] [-q] -o OUTDIR  file1.php file2.php ...
       bencoder [-f] [-q] -o OUTDIR  -s SRCDIR  [-e SUFFIX] [-r] [-c] [-l]

  -o FILE   : the file name to write the encoded script
              (default to '-encoded.XXX' suffix)
  -o OUTDIR : the directory to write all encoded files

  -a SRCDIR
  -s SRCDIR : encode all files in this source directory

  -r        : encode directories recursively (no by default)
  -f        : force overwriting even if the target exists
  -e SUFFIX : encode the files with the SUFFIX extension only (default: php)
              (regular expression allowed, ex: "php|inc")
  -c        : copy files those shouldn't be encoded (no by default)
  -l        : follow symbolic link (no by default)
  -q        : do not print the file name while encoding or copying
  -b
  -bz2      : compress the encoded files with bz2 (needs bzip2-extension)

HELP;

if( !function_exists( 'bcompiler_write_file' ) ) {
	print "$title\n\n";
	print "ERROR: Please install `bcompiler' before running this encoder\n\n";
	print "  cmd> pecl install channel://pecl.php.net/bcompiler-0.8\n\n";
	exit;
}

$suffix = 'php|html|htm';
$output = $srcdir = '';
$infiles = array();
$verbose = true;
$compress = false;
$follow_symlink = $force_overwrite = $copy_rest = $recursive = false;

for( $i=1 ; $i < $_SERVER['argc']; $i++ ) {
	switch( $_SERVER['argv'][$i] ) {
	case '-h':
		bencoder_print_usage();
		break;

	case '-b':
	case '-bz2':
		if( !function_exists('bzopen') )
			bencoder_error('bzip2 extension is not installed');
		$compress = true;
		break;

	case '-f':
		$force_overwrite = true;
		break;

	case '-o':
		if( ++$i < $_SERVER['argc'] )
			$output = $_SERVER['argv'][$i];
		break;

	case '-s':
	case '-a':
		if( ++$i < $_SERVER['argc'] )
			$srcdir = $_SERVER['argv'][$i];
		break;

	case '-e':
		if( ++$i < $_SERVER['argc'] )
			$suffix = $_SERVER['argv'][$i];
		break;

	case '-c':
		$copy_rest = true;
		break;

	case '-r':
		$recursive = true;
		break;

	case '-l':
		$follow_symlink = true;
		break;

	case '-q':
		$verbose = false;
		break;

	default:
		if( preg_match( '/^-o(.+)$/', $_SERVER['argv'][$i], $match ) ) {
			$output = $match[1];
		}
		else {
			$infiles[] = $_SERVER['argv'][$i];
		}
	}
}

$numfiles = count($infiles);

$outdir = '';
if( $numfiles > 0 || $srcdir != '' )
	$outdir = $output;

if( $srcdir == '' ) {
	if( $numfiles == 0 )
		bencoder_print_usage();
	if( $numfiles > 1 && $outdir == '' )
		bencoder_error("You should use `-o DIR' to specify the output directory");
}
else {
	if( $numfiles > 0 )
		bencoder_error("You can not encode files and specify `-a DIR' at the same times");
	if( $outdir == '' )
		bencoder_error("You should use `-o DIR' to specify the output directory");
}

if( $outdir != '' ) {
	if( file_exists( $outdir ) ) {
		if( !is_dir($outdir) )
			bencoder_error("[$outdir] already exists and is not a directory");
		if( !$force_overwrite )
			bencoder_error("The directory [$outdir] already exists,\n\tuse -f to force overwriting");
	}
	elseif( $numfiles > 1 )
		mkdir( $output, 0755 );
}

if( $srcdir != '' ) {
	bencoder_process_dir( $srcdir, $output );
}
elseif( $numfiles == 1 ) {
	if( $output == '' ) {
		$ext = substr( strrchr( $infiles[0], '.' ), 1 );
		if( $ext )
			$output = basename( $infiles[0], ".$ext" ) . "-encoded.$ext";
		else
			$output = $infiles[0] . '-encoded';
	}
	elseif( is_dir($output) )
		$output = $outdir.'/'.$infiles[0];
	if( file_exists($output) && !$force_overwrite )
		bencoder_error("The file [$output] already exists,\n\tuse -f to force overwriting");
	if( $verbose )
		print "$title\n\n";
	bcompiler_encode_file( $infiles[0], $output );
}
else {
	if( $verbose )
		print "$title\n\n";
	foreach( $infiles as $infile ) {
		bcompiler_encode_file( $infile, "$outdir/$infile" );
	}
}

exit(0);

function bencoder_process_dir( $srcdir, $outdir ) {
	global $follow_symlink, $copy_rest, $suffix;
	global $recursive, $force_overwrite;
	$dh = opendir($srcdir);
	while (($file = readdir($dh)) !== false) {
		if( $file == '.' || $file == '..' )
			continue;
		$srcpath = "$srcdir/$file";
		$outpath = "$outdir/$file";
		if( is_link($srcpath) ) {
			$real = readlink($srcpath);
			$realpath = ($real[0]=='/')?$real:"$srcdir/$real";
			if( $follow_symlink ) {
				$srcpath = $realpath;
			}
			else {
				if( $recursive || (!is_dir($realpath) && $copy_rest) ) {
					if( file_exists($outpath) && $force_overwrite )
						@unlink($outpath);
					symlink( $real, $outpath );
					bencoder_show_verbose("symlink: $outpath");
				}
				else
					bencoder_show_verbose("skipped: $outpath");
				continue;
			}
		}
		if( is_dir($srcpath) ) {
			if( $recursive ) {
				if( !file_exists( $outpath ) ) {
					bencoder_show_verbose("  mkdir: $outpath");
					mkdir($outpath,0755);
				}
				elseif( !is_dir($outpath) )
					bencoder_error("$outpath is not a directory");
				bencoder_process_dir( $srcpath, $outpath );
			}
		}
		elseif( is_readable($srcpath) ) {
			if( file_exists($outpath) && !$force_overwrite )
				bencoder_show_verbose("skipped: $outpath");
			elseif( preg_match( "/\.($suffix)\$/", $file ) )
				bcompiler_encode_file( $srcpath, $outpath );
			elseif( $copy_rest ) {
				if( @copy( $srcpath, $outpath ) )
					bencoder_show_verbose(" copied: $outpath");
				else
					print "   copy: $outpath (failed)\n";
			}
			continue;
		}
		else
			print " failed: $outpath (un-readable)\n";
	}
	closedir($dh);
}

function bcompiler_encode_file( $infile, $outfile ) {
	global $compress;
	$fh = fopen( $outfile, 'w');
	bcompiler_write_header($fh);
	bcompiler_write_file($fh, $infile);
	bcompiler_write_footer($fh);
	fclose($fh);
	if( $compress ) {
		$content = file_get_contents($outfile);
		$bzfh = bzopen($outfile, "w");
		bzwrite($bzfh, $content);
		bzclose($bzfh);
		bencoder_show_verbose("encoded & compressed: $outfile");
   	}
	else
  		bencoder_show_verbose("encoded: $outfile");

	return(1);
}

function bencoder_error( $err ) {
	global $title;
	print "$title\n\n";
	print "ERROR: $err\n\n";
	exit(1);
}

function bencoder_print_usage() {
	global $help;
	print $help;
	exit(0);
}

function bencoder_show_verbose( $msg ) {
	global $verbose;
	if( $verbose )
		print "$msg\n";
}

?>
