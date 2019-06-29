<?php
if (isset($_SERVER["REQUEST_URI"])){
    $path = $_SERVER["REQUEST_URI"];
    $params = preg_split('|/|', $path, -1, PREG_SPLIT_NO_EMPTY);
    $data = array(
        "tullow" => array(
            1 => "https://careers.tullowoil.com/job/Accra-Lead-EHS-Advisor-Job/551489700/",
            2 => "https://careers.tullowoil.com/job/London-Group-Financial-Accountant-Job/527484500/"
        ),
        "vodafone" => array(
            1 => "https://vodafone.taleo.net/careersection/application.jss?type=1&lang=en&portal=20170110040&reqNo=1316208",
            2 => "https://vodafone.taleo.net/careersection/application.jss?type=1&lang=en&portal=20170110040&reqNo=1301305",
            3 => "https://careers.vodafone.com/Apply?jid=23227",
            4 => "https://careers.vodafone.com/Apply?jid=23228"
        ),
        "mtn" => array(
            1 => "https://leap.ly/organizations/29"
        ),
        "halliburton" => array(
            1 => "https://jobs.halliburton.com/job/Takoradi-Ghana-Takoradi-ElectricalMechanical-LWD-Technicial-III-AA/546653900",
            2 => "https://jobs.halliburton.com/job/Accra-Ghana-Accra-Tech-Advisor-Reserv-Evaluation-AA/548504800"
        ),
        "ge" => array(
            1 => "https://jobs.gecareers.com/global/en/job/3271974/Product-Service-Engineer-Gas-Turbines-Electrical"
        ),
        "afdb" => array(
            1 => "https://www.afdb.org/en/about-us/careers/current-vacancies/2019-internship-program-4065/"
        ),
        "siemens" => array(
            1 => "https://jobs.siemens-info.com/jobs/107413/details?lang=en-gb&ats=jibeapply"
        ),
        "maersk" => array(
            1 => "https://jobsearch.maersk.com/jobposting/index.html?id=ML-189190# "
        ),
        "google" => array(
            1 => "https://www.google.com/about/careers/applications/signin?jobId=CiQAL2FckWoDkiEf-l4NdX7bTn5Xia-UHNATW3AM6dfkfX1-R1QSOgASYQ8wjji3bBQEhdFgVZwB42uWKJK_dfjKgsVK1961qRH7SAx0eTIwTxhvFQvo1DbnBi5QyiZRi3s%3D_V2&jobTitle=Research+Intern%2C+2019&loc=GH&_ga=2.207940817.218678854.1556652351-1612875089.1556652351",
            2 => "https://www.google.com/about/careers/applications/signin?jobId=CiQAL2FckUUoS4P0q_q4nYT75JLzyL4cEkebcjHwTE5ASG4s4IcSOgCPMA3TWe_l_0sXpaHoQ9EXNeXtRCvY96p0uwDBb6UnLaUP3YdOMcV0dl2SaQBBp7OlXhx8EF_l3rY%3D_V2&jobTitle=Software+Engineer%2C+Research+and+Machine+Intelligence&loc=GH&_ga=2.203294674.218678854.1556652351-1612875089.1556652351"
        ),
        "abinbev" => array(
            1 => "https://www.linkedin.com/jobs/view/externalApply/1129222845?url=http%3A%2F%2Fabinbevafricagraduates%2Ecom%2F&urlHash=drux&trk=guest_job_details_apply_link_offsite"
        ),
        "dangote" => array(
            1 => "https://www.jobberman.com.gh/job/management-and-plant-traineeship-program-rv8n5m"
        )
    );
    $url = "Location: " . $data[$params[0]][$params[1]];
    header($url, true, 301);
    exit();
} else {
    header("home");
}