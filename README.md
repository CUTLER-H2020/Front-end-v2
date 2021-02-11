# CUTLER-Front-end-v2
CUTLER Front-end v2 


The CUTLER platform aims to enable policy makers and public administrations to explore the opportunities offered by big data for improving policy design and monitoring. The platform employs big data analytics to measure the economic activity, assess the environmental impact and evaluate the social consequences of policy making.

The platform offers a multi-facet frontend implementing the IAMER approach and integrates the visualization of kibana widgets for assessing the economic, environmental and social impact of policy making.

This section describes the updated CUTLER Front-end v2 for supporting evidence-based policy making. The Front-end application offers a multi-facet interface for implementing the IAMER approach and integrates the visualization widgets for assessing the economic, environmental and social impact of policy making. Moreover, it allows dynamic creation and management of all policies and decision-making processes within the IAMER approach. 

Please check D8.3 and D8.5 for CUTLER Front-end technical details.

[D8.3 Integrated CUTLER Platform and multifacet dashboard](https://www.cutler-h2020.eu/download/557)

Software consisting of: a) the CUTLER platform integrating the methodologies and tools developed in WP4, WP5, WP6 and the BPM model developed in WP7, and b) the CUTLER dashboard that will integrate the visualization widgets and implement the IAMER approach in multi-facet layout. D8.5 will be the update of D8.3 on M30.


[D8.5 Update of the integrated CUTLER Platform and multi-facet dashboard](https://www.cutler-h2020.eu/download/1199)

Update of D8.3, where the CUTLER platform integrating the methodologies and tools and dashboard will be updated based on the revisions derived from the first phase pilots.



This document provides the following.

 Installation requirements

CUTLER uses PHP laravel framefork and MySQL database plasae install according to requirements below.

	CUTLER Front-end Lite Requirements
		1.	Php 7.2.5
		2.	Php Extensions
			a.	BCMath PHP Extension
			b.	Ctype PHP Extension
			c.	Fileinfo PHP extension
			d.	JSON PHP Extension
			e.	Mbstring PHP Extension
			f.	OpenSSL PHP Extension
			g.	PDO PHP Extension
			h.	Tokenizer PHP Extension
			i.	XML PHP Extension 
		3.	PHP Laravel Framework
		4.	Mysql

Please follow the guidelines step by step in the [PHP Laravel Framework](https://laravel.com/docs/7.x/installation ) documentation given below.


Then follow these steps to set up CUTLER environment.

1.	Run the "composer install" on command prompt.
2.	Change the name of the .env.example file to .env.
3.	Set the DB_ parameters in the .env file according to your mysql database.
4.	Run the "php artisan key: generate" command on the console screen.
5.  Set up database via “Php artisan migrate –seed ”.
6.	Run the "php artisan serve" command to run the project.


Please follow the guidelines in the frontend manual to create your users and deploy your policies and processes.
This lite version does not support process design and analytics.


 [CUTLER Front-end manual](https://www.cutler-h2020.eu/download/668)

CUTLER Front-end Manual:
The CUTLER platform provides a combination of data-driven and model-driven approaches and visual-based decision support for policy making, through a big data processing and visualization environment.
The platform is a multi-tenant solution that integrates the visualization widgets for assessing the economic, environmental and social impact of policy making developed in WP4,5,6 and allows public authorities to define and implement their policies through the lens of the IAMER approach. In each city, different user groups can be defined, including admin, designers and analysers. These users require different features while they are using the platform. The manual describes how to use the CUTLER platform to create IAMER-based dashboards for managing new policies.




