<?php

    function lang($phrase){
        
        static $lang = array(
            
            "HOME" => "Home",
            "CATEGORIES" => "Brands",
            "SEARCH" => "Search",
            "SETTINGS" => "Settings",
            "EDIT" =>"Modify Account",
            "DELETE" => "Delete",
            "ACTIVATE" => "Activate",
            "DELETEMEMBER" => "Delete member",
            "ADDMEMBER" => "Add new member",
            "ITEMS" => "Ads",
            "MEMBERS" => "Members",
            "STATISTICS" => "Statistics",
            "LOGS" => "Logs",
            "LOGOUT" => "Log out",
            "ID" => "Id",
            "USERNAME" => "Username",
            "PASSWORD" => "Password",
            "EMAIL" => "Email",
            "FULLNAME" => "Full name",
            "REGDATE" => "Registration date",
            "CONTROL" => "Control",
            "SAVE" => "Save",
            "UPDATE" => "Update member",
            "USERERROR" => "Username must start with a letter and contains at least 8 to 30 characters",
            "EMAILERROR" => "Email can't be empty",
            "FULLNAMERROR" => "Full name can't be empty",
            "STRLEN" => "Username must contain at least 5 characters",
            "STRLEN1" => "Username must containe less than 30 characters",
            "USER-EXIST" => "Sorry! This username is already taken by another member",
            "USER-NOT-EXIST" => "Sorry ! There is no such member or this account was deleted",
            "MANAGE-MEMBERS" => "Manage members",
            "ADD" => "Add",
            "ILLEGAL-BROWSING" => "Sorry! you can't browse this page directly",
            "TOTAL-MEMBERS" => "Total members",
            "LATEST-MEMBERS" => "Latest members",
            "TOTAL-ITEMS" => "Total ads",
            "TOTAL-COMMENTS" => "Total comments",
            "LATEST-MEMBERS" => "Latest members",
            "LATEST-ITEMS" => "Latest ads",
            "ACTIVATE-MEMBER" => "Activate members",
            "ADD-CATEGORY" => "إضافة فئة جديدة",
            "NAME" => "Brand's name",
            "DESCRIPTION" => "Description",
            "DESC-MSG" => "Desription of this brand",
            "ORDERING" => "Ordering",
            "VISIBLE" => "Visible",
            "YES" => "Yes",
            "NO" => "No",
            "COMMENTS" => "Comments",
            "ADS" => "Ads",
            "CATEGORY-NAME-ERROR" => "Brand's name should contain at least 2 characters up to 30.",
            "USER-EXIST" => " Sorry! This username is already taken by someone else",
            "MANAGE-CATEGORIES" => "Brands manager",
            "NO-DESC" => "This brand contains no description",
            "CAT-LIST" => "Brand's list",
            "HIDDEN" => "Hidden",
            "VIS" => "Visible",
            "COM-DIS" => "Comments are disabled",
            "ADS-DIS" => "Ads are disable",
            "EDIT2" => "Edit",
            "ORDER-TYPE" => "Ordering",
            "ASC" => "Ascending",
            "DESC" => "Descending",
            "EDIT-CAT" => "Edit brand",
            "ADD-NEW-CATEGORY" => "New brand",
            "ADD-AD" => "New Ad",
            "PRICE" => "Price",
            "NAME-AD" => "Ad title",
            "WILAYA" => "City",
            "STATUS" => "Status",
            "VERY-GOOD" => "New",
            "GOOD" => "Good",
            "NORMAL" => "Normal",
            "OLD" => "Old",
            "DAMAGED" => "Damaged",
            "AD-NAME-ERROR" => "Ad name must be more than 3 characters",
            "AD-NAME-ERROR1" => "Ad name must be less than 30 characters",
            "DATE-AD" => "Ad date",
            "EDIT-AD" => "Edit ad",
            "NEW-AD" => "New ad",
            "UPDATE-AD" => "Update ad",
            "DELETE-AD" => "Delete ad",
            "CONTENT" => "Content",
            "COM-DATE" => "Comment date",
            "DELETE-COM" => "Delete comment",
            "MANAGE-COM" => "Comments manager",
            "DISPLAY" => "Display",
            "SHOW-AD" => "Show ad",
            "MANAGE-AD" => "Ads manager",
            "LATEST-COMMENTS" => "Latest comments",
            "NO-ADS" => "There is no ads to show !",
            "NO-COM" =>  "There is no comments to show",
            "NO-MEMBERS" => "There is no memebers to show",
            "ADDED-BY" => "Added by",
            "LOGIN" => "Login",
            "PARENT" => "فرع رئيسي",
            "SUB-CATEGORIES" => "Sub categories",
            "DASHBOARD" => "Dashboard",
            "ADMIN" => "Admin",
            "PASSERROR" => "Password should contain at least 8 characters, at least one uppercase letter, one lowercase letter, one number and one special character",
            "TAGS" => "Tags",
            "PROFILE-PIC" => "Profile picture",
            "WILAYAS" => "Ads per Wilayas",
            "GENERAL-STATS" => "General stats",
            "NEW-ADS" => "New ads of this week",
            "NEW-MEMBERS" => "New Members of this week",
            "SEE-ALL" => "See All",
            "TOTAL" => "Total",
            "NOT-ALLOWED-EXT" => "This exstention is not allowed!Please chose a valid one",
            "BIG-SIZE" =>"Image size must be less than 5 mb",
            "ADD-ADMIN" => "Add an admin",
            "PHONE-NUM" => "Phone number",
            "BIRTH-DATE" => "Birth date",
            "UPDATE-CAT" => "Update a brand",
            "LOGIN-ERROR" => "You have entered an invalid username or password !",
            "INBOX" => "Inbox",
            "JAN" => "January",
            "FEB" => "February",
            "MAR" => "March",
            "APR" => "April",
            "MAY" => "May",
            "JUN" => "June",
            "JUL" => "July",
            "AUG" => "August",
            "SEP" => "September",
            "OCT" => "October",
            "NOV" => "November",
            "DEC" => "December",
            "USERS-PER-MONTH" => "Number of users signed up per month",             
            "SUBJECTS" => "Subjects",
            "MANAGE-SUBJECTS" => "Manage subjects",
            "DISPLAY" => "Display",
            "ITEMS-NUM" => "Number of ads",
            "CAT-EXIST" => "This brand doesn't exist or it was deleted",
            "ADS-PER-MONTH" => "Number of ads added per month",
            "PENDING" => "Pending",
            "THIS-WEEK" => "This week",
            "WELCOME" => "Welcome",
            "UPGRADE-MSG" => "assign you an admin of this site",
            "AD-APPROVED" => "Your ad was approved",
            "SELECT-PHOTO" => "You must select a photo for the brand",
            "MEMBER-DELETED" => "Membre supprimé avec succès",
            "ADMINS" => "Admin manager"            
           
            
        );
        
        return $lang[$phrase];
        
    }