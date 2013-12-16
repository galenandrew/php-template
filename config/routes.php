<?php
	/**
	 * The routing array. Be sure to be as specific as possible,
	 * and keep in mind that the routes will check from bottom to 
	 * top from this array, and will stop once a match is
	 * found.
	 *
	 * Routes are dynamically generated and pass named parameters
	 * to the defined object and function.
	 *
	 * IN THE ARRAY:
	 * Field 1 => GET / POST / PUT / DELETE
	 * Field 2 => Route URL
	 * Field 3 => Object Class
	 * Field 4 => Object Class method
	 *
	 * DYNAMIC BLOCKS
	 * Surrounded by square brackets ([]), dynamic blocks tell the
	 * router to look for some sort of non-static match element. In
	 * other words, dynamic blocks are what make this routing system
	 * dynamic, DUH. Below is the list of current supported features:
	 *
	 * == NAMED PARAMETERS
	 *    :param                   Sends a parameter to the proper object
	 *                             with the given name (in this case, "param")
	 *
	 * == NAMED PARAMETER LIMITS
	 *    (a):param                Only alphabetical characters allowed.
	 *
	 *    (i):param                Only integers (numeric characters) allowed.
	 *
	 *    (a_):param               Only alphabetical characters, underscores,
	 *                             and minus signs allowed.
	 *
	 *    (a+):param               Only alphanumeric characters allowed.
	 *
	 *    (a_+):param              Only alphanumeric characters, underscores,
	 *                             and minus signs allowed.
	 *
	 * == OR CONDITIONAL ASSIGNMENT
	 *    :param=(this|that)       Will assign the matched OR CONDITIONAL
	 *                             to the NAMED PARAMETER.
	 *
	 * == EXCLUSIONARY CONDITIONAL ASSIGNMENT
	 *    :param!=this             So long as the parameter does NOT equal the
	 *                             following statement or conditional, the route
	 *                             will match and the match will be assigned to
	 *                             the named parameter.
	 *
	 * COMING SOON:
	 *
	 * == OR CONDITIONAL STATEMENT (CURRENTLY NOT AVAILABLE)
	 *    (this|that)              Will succeed if "this" or "that" is found
	 *                             in the given route location. There is no
	 *                             limit to the amount of statements placed
	 *                             in this conditional. [eg, (this|that|thang)]
	 *                             
	 * == REGEX CONDITIONAL ASSIGNMENT (NOT DONE YET)
	 *    :param=ex([a-z])         Will succeed if the parameter matches the
	 *                             regex passed inside of ex(); assigns the 
	 *                             regex match to the parameter.
	 */
	  
	$routes = array(
		array('/[:type=(commercial|residential)]', 'Type', 'view')
	);