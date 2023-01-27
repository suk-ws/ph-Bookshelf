/******************************************************************************
 ##############################################################################
 #####                                                                    #####
 #####   Web JavaScripts of ph-Bookshelf                                  #####
 #####     enhanced extension                                             #####
 #####     for [ling-title    rol]                                        #####
 #####                                                                    #####
 #####     @author: Sukazyo Workshop                                      #####
 #####     @version： 1.0                                                 #####
 #####                                                                    #####
 ##############################################################################
 ******************************************************************************/

const rollingTitle_rollingSpeed = 450;

function rollingTitle_titleRollChar () {
	
	let title = document.title;
	const start = title[0];
	title = title.substring(1);
	title += start;
	document.title = title;
	
	setTimeout(rollingTitle_titleRollChar, rollingTitle_rollingSpeed);
	
}

rollingTitle_titleRollChar();
