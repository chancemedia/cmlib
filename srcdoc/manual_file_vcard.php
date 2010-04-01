<?php

/**
 * @page manual_file_vcard 7.3. vCard
 * 
 * @section description Description
 * The vCard format is a text-based portable address book format for transmitting one or more
 * address book contacts.
 * 
 * @section usage Usage
 * Details here about why and where to use this class.
 * 
 * @section example Example
 * @code
 * // create the vCard object
 * $vcd = new CMFileVCF();
 * 
 * // add some vCards
 * $vcd->addCard(array('N' => "Bob Smith", 'TEL' => "1234 5678"));
 * $vcd->addCard(array('N' => "Joe Bloggs", 'TEL' => "7890 4567"));
 * 
 * // write to file
 * $vcd->writeFile("myCard.vcf");
 * @endcode
 * 
 * @section cmvcard_desc Description
 * vCard is a file format standard for electronic business cards. vCards are often attached to e-mail
 * messages, but can be exchanged in other ways, such as on the World Wide Web. They can contain name
 * and address information, phone numbers, e-mail addresses , URLs, logos, photographs, and even audio
 * clips.
 * 
 * @section cmvcard_example Example
 * Example 1: Creating a vCard
 * @code
 * $vcard = new CMVCard();
 * $vcard->add('FN', 'Forrest Gump');
 * $vcard->add('ORG', 'Bubba Gump Shrimp Co.');
 * $vcard->add('TEL;TYPE=WORK,VOICE', '(111) 555-1212');
 * echo $vcard->generateVCard();
 * @endcode
 * 
 * @section cmvcard_import Importing vCard data
 * This class only acts as a storage mechanism to create and generate a single vCards. As vCard files
 * or strings can contain mutiple vCards, use CMFileVCF::readString() to read a string of one or more
 * vCards. CMFileVCF keeps a stack of multiple vCards as well as native support to read such vCards to
 * and from files and strings.
 * 
 * @section cmvcard_file File Example
 * The following is an example of a VCard file containing information for one person:
 * vCard 2.1:
 * <pre>
 * BEGIN:VCARD
 * VERSION:2.1
 * N:kapukod;Hetszin
 * FN:4758
 * ORG:Bubba Gump Shrimp Co.
 * TITLE:Shrimp Man
 * TEL;CELL;VOICE:2536
 * X-IRMC_LUID 0002000002A7
 * END:VCARD
 * </pre>
 * 
 * vCard 3.0:
 * <pre>
 * BEGIN:VCARD
 * VERSION:3.0
 * N:Gump;Forrest
 * FN:Forrest Gump
 * ORG:Bubba Gump Shrimp Co.
 * TITLE:Shrimp Man
 * TEL;TYPE=WORK,VOICE:(111) 555-1212
 * TEL;TYPE=HOME,VOICE:(404) 555-1212
 * ADR;TYPE=WORK:;;100 Waters Edge;Baytown;LA;30314;United States of America
 * LABEL;TYPE=WORK:100 Waters Edge\\nBaytown, LA 30314\\nUnited States of America
 * ADR;TYPE=HOME:;;42 Plantation St.;Baytown;LA;30314;United States of America
 * LABEL;TYPE=HOME:42 Plantation St.\\nBaytown, LA 30314\\nUnited States of America
 * EMAIL;TYPE=PREF,INTERNET:forrestgump@example.com
 * REV:20080424T195243Z
 * END:VCARD
 * </pre>
 * 
 * @section cmvcard_properties Properties
 * vCard defines the following property types: *FN, *N, NICKNAME, *PHOTO, *BDAY, *ADR, *LABEL, *TEL,
 * *EMAIL, *MAILER, *TZ, *GEO, *TITLE, *ROLE, *LOGO, *AGENT, *ORG, CATEGORIES, *NOTE, PRODID, *REV,
 * SORT-STRING, *SOUND, *URL, *UID, *VERSION, CLASS, *KEY
 * 
 * <table>
 *   <tr>
 *     <th>Name</th>
 *     <th>Description</th>
 *     <th>Semantic</th>
 *   </tr>
 *   <tr>
 *     <td><tt>N</tt></td>
 *     <td>Name</td>
 *     <td>A structured representation of the name of the person, place or thing associated with the
 *         vCard object.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>FN</tt></td>
 *     <td>Formatted Name</td>
 *     <td>The formatted name string associated with the vCard object.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>PHOTO</tt></td>
 *     <td>Photograph</td>
 *     <td>An image or photograph of the individual associated with the vCard.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>BDAY</tt></td>
 *     <td>Birthday</td>
 *     <td>Date of birth of the individual associated with the vCard.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>ADR</tt></td>
 *     <td>Delivery Address</td>
 *     <td>A structured representation of the physical delivery address for the vCard object.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>LABEL</tt></td>
 *     <td>Label Address</td>
 *     <td>Addressing label for physical delivery to the person/object associated with the vCard.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>TEL</tt></td>
 *     <td>Telephone</td>
 *     <td>The canonical number string for a telephone number for telephony communication with the
 *         vCard object.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>EMAIL</tt></td>
 *     <td>Email</td>
 *     <td>The address for electronic mail communication with the vCard object.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>MAILER</tt></td>
 *     <td>Email Program (Optional)</td>
 *     <td>Type of email program used.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>TZ</tt></td>
 *     <td>Time Zone</td>
 *     <td>Information related to the standard time zone of the vCard object.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>GEO</tt></td>
 *     <td>Global Positioning</td>
 *     <td>The property specifies a latitude and longitude.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>TITLE</tt></td>
 *     <td>Title</td>
 *     <td>Specifies the job title, functional position or function of the individual associated with
 *         the vCard object within an organization (V. P. Research and Development).</td>
 *   </tr>
 *   <tr>
 *     <td><tt>ROLE</tt></td>
 *     <td>Role or occupation</td>
 *     <td>The role, occupation, or business category of the vCard object within an organization (eg.
 *         Executive).</td>
 *   </tr>
 *   <tr>
 *     <td><tt>LOGO</tt></td>
 *     <td>Logo</td>
 *     <td>An image or graphic of the logo of the organization that is associated with the individual
 *         to which the vCard belongs.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>AGENT</tt></td>
 *     <td>Agent</td>
 *     <td>Information about another person who will act on behalf of the vCard object. Typically this
 *         would be an area administrator, assistant, or secretary for the individual.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>ORG</tt></td>
 *     <td>Organization Name or Organizational unit</td>
 *     <td>The name and optionally the unit(s) of the organization associated with the vCard object.
 *         This property is based on the X.520 Organization Name attribute and the X.520 Organization
 *         Unit attribute.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>NOTE</tt></td>
 *     <td>Note</td>
 *     <td>Specifies supplemental information or a comment that is associated with the vCard.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>REV</tt></td>
 *     <td>Last Revision</td>
 *     <td>Combination of the calendar date and time of day of the last update to the vCard object.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>SOUND</tt></td>
 *     <td>Sound</td>
 *     <td>By default, if this property is not grouped with other properties it specifies the
 *         pronunciation of the Formatted Name property of the vCard object.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>URL</tt></td>
 *     <td>URL</td>
 *     <td>An URL is a representation of an Internet location that can be used to obtain real-time
 *         information about the vCard object.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>UID</tt></td>
 *     <td>Unique Identifier</td>
 *     <td>Specifies a value that represents a persistent, globally unique identifier associated with
 *         the object.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>VERSION</tt></td>
 *     <td>Version</td>
 *     <td>Version of the vCard Specification.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>KEY</tt></td>
 *     <td>Public Key</td>
 *     <td>the public encryption key associated with the vCard object.</td>
 *   </tr>
 * </table>
 * 
 * In addition, because vCard augments RFC-2425, a standard for directory information, the following
 * property types are also supported: SOURCE, NAME, PROFILE, BEGIN, END.
 * 
 * @section cmvcard_extensions Known vCard Extensions
 * vCard supports private extensions, with a "X-" prefix, a number of which are in common usage.
 * 
 * Some of these include:
 * <table>
 *   <tr>
 *     <th>Extension</th>
 *     <th>Used As</th>
 *     <th>Data</th>
 *     <th>Semantic</th>
 *   </tr>
 *   <tr>
 *     <td colspan="4" align="center">extensions supported by multiple different programs</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-ABUID</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>Apple Address Book UUID for that entry</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-ANNIVERSARY</pre></td>
 *     <td>property</td>
 *     <td>YYYY-MM-DD</td>
 *     <td>arbitrary anniversary, in addition to BDAY = birthday</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-ASSISTANT</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>assistant name (instead of Agent)</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-MANAGER</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>manager name</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-SPOUSE</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>spouse name</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-GENDER</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>value "Male" or "Female"</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-AIM</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>Instant Messaging (IM) contact information; TYPE parameter as for TEL (I.e. WORK/HOME/OTHER)
 *         </td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-ICQ</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>"</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-JABBER</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>"</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-MSN</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>"</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-YAHOO</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>"</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-SKYPE, X-SKYPE-USERNAME</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>"</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-GADUGADU</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>"</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-GROUPWISE</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>"</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-MS-IMADDRESS</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>" (IM address in VCF attachment from Outlook (right click Contact, Send Full Contact,
 *         Internet Format.)</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-MS-CARDPICTURE</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>Works as PHOTO or LOGO. Contains an image of the Card in Outlook.</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-PHONETIC-FIRST-NAME, X-PHONETIC-LAST-NAME</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>alternative spelling of name, used for Japanese names by Android and iPhone</td>
 *   </tr>
 *   <tr>
 *     <td colspan="4" align="center">
 *       introduced and used by Mozilla, also used by Evolution (software)
 *     </td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-MOZILLA-HTML</pre></td>
 *     <td>property</td>
 *     <td>\true/\false</td>
 *     <td>mail recipient wants HTML email</td>
 *   </tr>
 *   <tr>
 *     <td colspan="4" align="center">introduced and used by Evolution (software)</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-EVOLUTION-ANNIVERSARY</pre></td>
 *     <td>property</td>
 *     <td>YYYY-MM-DD</td>
 *     <td>arbitrary anniversary, in addition to BDAY = birthday</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-EVOLUTION-ASSISTANT</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>assistant name (instead of Agent)</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-EVOLUTION-BLOG-URL</pre></td>
 *     <td>property</td>
 *     <td>string/URL</td>
 *     <td>blog URL</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-EVOLUTION-FILE-AS</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>file under different name (in addition to N = name components and FN = full name</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-EVOLUTION-MANAGER</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>manager name</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-EVOLUTION-SPOUSE</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>spouse name</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-EVOLUTION-VIDEO-URL</pre></td>
 *     <td>property</td>
 *     <td>string/URL</td>
 *     <td>video chat address</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-EVOLUTION-CALLBACK</pre></td>
 *     <td>TEL TYPE parameter value</td>
 *     <td>-</td>
 *     <td>callback phone number</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-EVOLUTION-RADIO</pre></td>
 *     <td>TEL TYPE parameter value</td>
 *     <td>-</td>
 *     <td>radio contact information</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-EVOLUTION-TELEX</pre></td>
 *     <td>TEL TYPE parameter value</td>
 *     <td>-</td>
 *     <td>Telex contact information</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-EVOLUTION-TTYTDD</pre></td>
 *     <td>TEL TYPE parameter value</td>
 *     <td>-</td>
 *     <td>TTY TDD contact information</td>
 *   </tr>
 *   <tr>
 *     <td colspan="4" align="center">introduced and used by Kontact and KAddressBook</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-KADDRESSBOOK-BlogFeed</pre></td>
 *     <td>property</td>
 *     <td>string/URL</td>
 *     <td>blog URL</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-KADDRESSBOOK-X-Anniversary</pre></td>
 *     <td>property</td>
 *     <td>ISO date</td>
 *     <td>arbitrary anniversary, in addition to BDAY = birthday</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-KADDRESSBOOK-X-AssistantsName</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>assistant name (instead of Agent)</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-KADDRESSBOOK-X-IMAddress</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>im address</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-KADDRESSBOOK-X-ManagersName</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>manager name</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-KADDRESSBOOK-X-Office</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>office description</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-KADDRESSBOOK-X-Profession</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>profession</td>
 *   </tr>
 *   <tr>
 *     <td><pre>X-KADDRESSBOOK-X-SpouseName</pre></td>
 *     <td>property</td>
 *     <td>string</td>
 *     <td>spouse name</td>
 *   </tr>
 * </table>
 * 
 */

?>
