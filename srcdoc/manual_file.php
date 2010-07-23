<?php

/**
 * @page manual_file 7. File Parsing
 * 
 * @section manual_file_subpages Subpages
 * -# \subpage manual_file_csv
 * -# \subpage manual_file_ical
 * -# \subpage manual_file_vcard
 * 
 * 
 * @section manual_file_intro Introduction
 * 
 * CMFileParser provides an interface for classes to normalise the operating of reading files, in a similar
 * way that CMDatabaseProtocol uses a standard set of functions that connect to different backend databases.
 * 
 * As there are so many different file types that are handled in a variety of ways not all classes will
 * implement all the methods from the CMFileParser interface. You will need to check the documentation for
 * the classes specific to the type of file you are reading/writing.
 * 
 * 
 * @section manual_file_multi Multirecord Files
 * 
 * Some file types contain a single entity (like an image) and some files contain zero or more entities
 * like a vCard file.
 * 
 * 
 * @section manual_file_cache Caching
 * 
 * 
 * 
 */

?>
