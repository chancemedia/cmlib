<?php

/**
 * @page manual_file_ical 7.2. VCalendar
 * 
 * @section cmvcalendar_properties Properties
 * <table>
 *   <tr valign="top">
 *     <th>Class</th>
 *     <th>Description</th>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Action</tt></td>
 *     <td> Defines Action component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Attachment</tt></td>
 *     <td> Defines the ATTACH component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>AttachmentCollection</tt></td>
 *     <td> Strongly typed collection for managing the Attachment objects. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Attendee</tt></td>
 *     <td> Defines Attendee component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>AttendeeCollection</tt></td>
 *     <td> Strongly typed collection for managing the Attendee objects. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>CalendarScale</tt></td>
 *     <td> Defines CalendarScale component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Categories</tt></td>
 *     <td> The Categories component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Classification</tt></td>
 *     <td> The Classification component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Comment</tt></td>
 *     <td> The Comment component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>CommentCollection</tt></td>
 *     <td> Strongly typed collection for managing the Comment objects. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Completed</tt></td>
 *     <td> The Completed component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Contact</tt></td>
 *     <td> The Contact component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>ContactCollection</tt></td>
 *     <td> Strongly typed collection for managing the Contact objects. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Created</tt></td>
 *     <td> The Created component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>DateTimeDue</tt></td>
 *     <td> The DateTimeDue component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>DateTimeEnd</tt></td>
 *     <td> The DateTimeEnd component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>DateTimeStamp</tt></td>
 *     <td> The DateTimeStamp component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>DateTimeStart</tt></td>
 *     <td> The DateTimeStart component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Description</tt></td>
 *     <td> The Description component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Duration</tt></td>
 *     <td> The Duration component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>ExceptionDate</tt></td>
 *     <td> The ExceptionDate component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>ExceptionRule</tt></td>
 *     <td> The ExceptionRule component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>ExceptionRuleCollection</tt></td>
 *     <td> Strongly typed collection for managing the ExceptionRule objects. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>FreeBusy</tt></td>
 *     <td> The FreeBusy component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>GEO</tt></td>
 *     <td> The GEO component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>LastModified</tt></td>
 *     <td> The LastModified component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Location</tt></td>
 *     <td> The Location component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Method</tt></td>
 *     <td> The Method component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>NonstandardProperty</tt></td>
 *     <td> The Non-standard component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>NonstandardPropertyCollection</tt></td>
 *     <td> Strongly typed collection for managing the NonstandardProperty objects. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Organizer</tt></td>
 *     <td> The Organizer component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>PercentComplete</tt></td>
 *     <td> The PercentComplete component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Period</tt></td>
 *     <td> Defines a time period. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Priority</tt></td>
 *     <td> The Priority component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>ProductIdentifier</tt></td>
 *     <td> The ProductIdentifier component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Property</tt></td>
 *     <td> The base class for all the iCalendar Component Properties. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>PropertyCollection</tt></td>
 *     <td> Strongly typed collection for managing the Property objects. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>RecurrenceDate</tt></td>
 *     <td> The RecurrenceDate component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>RecurrenceIdentifier</tt></td>
 *     <td> The RecurrenceIdentifier component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>RecurrenceRule</tt></td>
 *     <td> The RecurrenceRule component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>RecurrenceRuleCollection</tt></td>
 *     <td> Strongly typed collection for managing the RecurrenceRule objects. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>RelatedTo</tt></td>
 *     <td> The RelatedTo component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>RelatedToCollection</tt></td>
 *     <td> Strongly typed collection for managing the RelatedTo objects. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Repeat</tt></td>
 *     <td> The Repeat component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>RequestStatus</tt></td>
 *     <td> The RequestStatus component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>RequestStatusCollection</tt></td>
 *     <td> Strongly typed collection for managing the RequestStatus objects. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Resources</tt></td>
 *     <td> The Resources component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Sequence</tt></td>
 *     <td> The Sequence component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Status</tt></td>
 *     <td> The Status component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Summary</tt></td>
 *     <td> The Summary component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>TimeTransparency</tt></td>
 *     <td> The TimeTransparency component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>TimeZoneIdentifier</tt></td>
 *     <td> The TimeZoneIdentifier component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>TimeZoneName</tt></td>
 *     <td> The TimeZoneName component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>TimeZoneOffsetFrom</tt></td>
 *     <td> The TimeZoneOffsetFrom component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>TimeZoneOffsetTo</tt></td>
 *     <td> The TimeZoneOffsetTo component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>TimeZoneURL</tt></td>
 *     <td> The TimeZoneURL component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Trigger</tt></td>
 *     <td> The Trigger component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>UniqueIdentifier</tt></td>
 *     <td> The UniqueIdentifier component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>URL</tt></td>
 *     <td> The URL component property. </td>
 *   </tr>
 *   <tr valign="top">
 *     <td><tt>Version</tt></td>
 *     <td> The Version component property. </td>
 *   </tr>
 * </table>
 * 
 */

?>
