<?php
return [
    'message' => [
        'user' => [
            'create' => 'Created :name with :email by :user_created.',
            'update' => '{1}Updated :field to :value for :affected_user by :user_created.|
            {2} :user_created :type :type_name :type_update for :affected_user.|
            {3} Sync :role_name roles for :affected_user by :user_created.|
            {4} Sync :group_name groups for :affected_user by :user_created.|
            {5} The password reset link has been sent to :email by :user_created.|
            {6} :affected_user\'s avatar is changed by :user_created.|
            {7} :affected_user\'s information is changed by :user_created.|
            {8} :affected_user\'s password is changed by :user_created.',
            'delete' => 'Deleted :name with :email by :user_created.',
            'rollback' => ':name with :email is rollback by :user_created.'
        ],
        'group' => [
            'create' => ':user_created created :name group.',
            'update' => ':user_created changed :old_name to :new_name group.',
            'add-user' => ':affected_user is attached to :group_name group by :user_created.',
            'remove-user' => ':affected_user is detached from :group_name group by :user_created.',
            'delete' => ':user_created deleted :group_name group.',
            'update' => ':user_created :type :type_name :type_update for :group_name group.',
        ],
        'ticket' => [
            'create' => ':title Ticket #:id has been created by :user_created.',
            'assignee' => ':user_created assigned ticket #:id to :affected_user.',
            'assign_list' => ':user_created assigned ticket:s :id to :affected_user.',
            'remove_assignee' => ':user_created removed assignee :affected_user from ticket #:id.',
            'delete' => ':user_created deleted ticket #:id.',
            'delete_list' => ':user_created deleted ticket:s :id.',
            'invite' => ':user_created invited :affected_user to ticket #:id.',
            'closed' => ':user_created closed ticket #:id.',
            'reviewed' => ':user_created requested review ticket #:id.',
            'approved' => ':user_created approved ticket #:id.',
            'denied' => ':user_created denied ticket #:id.',
            'deny' => ':user_created denied ticket #:id.',
            'comment' => ':user_created had comment in ticket #:id.',
            'folowing' => ':user_created is folowing ticket #:id.',
            'un_follow' => ':user_created removed Follower :follower from ticket #:id.',
            'remove-invite' => ':user_created removed invited :affected_user from ticket #:id.',
            'add-follow' =>':user_created added follow :affected_user to ticket #:id.',
            'update_due_date' =>':user_created updated due date to :due_date for ticket #:id.',
            'update_due_date_list' =>':user_created updated due date to :due_date for ticket:s :id.',
            'request_extension' =>':user_created requested extension to :extension for ticket #:id.',
            'approve_extension' =>':user_created approved extension :extension for ticket #:id.',
            'update_percent' =>':user_created updated percent complete to :percent% for ticket #:id.',
        ],
        'type' => [
            'create' => ':user_created created :name type.',
            'update' => ':user_created updated :name type.',
            'delete' => ':user_created deleted :name type.',
        ],
        'permission' => [
            'create' => ':user_created created :name permission.',
            'update' => ':user_created updated :name permission.|
                        {2} :affected_user is attached to :permission_name permission by :user_created.|
                        {3} :user_created attached :group_name group to :permission_name permission.|
                        {4} :affected_user is detached from :permission_name permission by :user_created.|
                        {5} :user_created detached :group_name group from :permission_name permission.',
            'delete' => ':user_created deleted :name permission.'
        ],
        'role' => [
            'create' => ':user_created created :name role.',
            'update' => ':user_created updated :name role.|
                        {2} :affected_user is attached to :role_name role by :user_created.|
                        {3} :user_created attached :group_name group to :role_name role.|
                        {4} :user_created attached :permission_name permission to :role_name role.|
                        {5} :affected_user is detached from :role_name role by :user_created.|
                        {6} :user_created detached :group_name group from :role_name role.|
                        {7} :user_created detached :permission_name permission from :role_name role.',
            'delete' => ':user_created deleted :name role.'
        ],
        'template' => [
            'create' => '{1}:user_created created new template :name.|
                         {2}:user_created proposed new template :name.|
                         {3}:user_created created :folder_name folder in templates.|
                         {4}:user_created requested translation :name (:language-:region) in templates.|
                         {5}:user_created requested region :name (:language-:region) in templates.',
            'update' => '{1}:user_created updated :name (:language-:region) in templates.|
                         {2}:user_created renamed :oldName to :newName folder in templates.|
                         {3}:user_created attached :tagName tag to :name template.|
                         {4}:user_created detached :tagName tag from :name template.',
            'delete' => '{1}:user_created deleted :name template.|
                         {2}:user_created deleted :name folder in templates.|
                         {3}:user_created deleted :name (:language-:region) in templates.',
        ],
        'page' => [
            'create' => '{1}:user_created proposed new :name page.| 
                         {2}:user_created requested region :name (:language-:region) in pages.|
                         {3}:user_created requested translation :name (:language-:region) in pages.|
                         {4}:user_created requested revision :name (:language-:region) in pages.|
                         {5}:user_created created redirect :oldUrl old page with :header header to :name (:language-:region) in pages.',
            
            'update' => '{1}:user_created updated :name (:language-:region) in pages .|
                         {2}:user_created renamed from :oldName to :newName in pages.|
                         {3}:user_created attached :tagName tag to :name page.|
                         {4}:user_created detached :tagName tag from :name page.|
                         {5}:name is moved to :parentName by :user_created in pages.',
            'delete' => '{1}:user_created deleted :name page.|
                         {2}:user_created deleted :name in pages (:language-:region).|
                         {3}:user_created deleted redirect :oldUrl old page with :header header from :name in pages (:language-:region).'
        ],
        'asset' => [
            'create' => '{1}:user_created created new Asset :name.|
                         {2}:user_created Uploaded new Asset :name.|
                         {3}:user_created proposed new Asset :name .|
                         {4}:user_created created :folder_name folder in asset.|
                         {5}:user_created requested translation :name asset (:language-:region).|
                         {6}:user_created requested region :name asset (:language-:region).',
            'update' => '{1}:user_created updated :name asset (:language-:region).|
                         {2}:user_created renamed :oldName to :newName folder in asset.|
                         {3}:user_created attached :name asset to :tagName tag.|
                         {4}:user_created detached :name asset to :tagName tag.',
            'delete' => '{1}:user_created deleted :name asset.|
                         {2}:user_created deleted :name folder in asset.|
                         {3}:user_created deleted :name asset (:language-:region).',
        ],
        'block' => [
            'create' => '{1}:user_created created new :name block.| 
                         {2}:user_created requested new :name block.|
                         {3}:user_created requested region :name (:language-:region) in blocks.|
                         {4}:user_created requested translation :name (:language-:region) in blocks.|
                         {5}:user_created created :name. folder in blocks',
            'update' => '{1}:user_created updated :name in blocks.|
                         {2}:user_created renamed from :oldName to :newName folder in blocks.|
                         {3}:user_created attached :tagName tag to :name block.|
                         {4}:user_created detached :tagName tag from :name block.',
            'delete' => '{1}:user_created deleted :name block.|
                         {2}:user_created deleted :name folder in blocks.|
                         {3}:user_created deleted :name (:language-:region) in blocks.'
        ],
        'material' => [
            'create' => '{1}:user_created created new :name in material.|
                         {2}:user_created created :name category in material.',
            'update' => ':user_created updated :name in material.',
            'delete' => '{1}:user_created deleted :name in material.|
                         {2}:user_created deleted :name folder in material.'
        ],
        'document' => [
            'create' => '{1}:user_created uploaded file :name in  Document Management.|
                         {2}:user_created created :name folder in  Document Management.',
            'update' => '{1}:user_created renamed from :oldName to :newName file in  Document Management.|
                         {2}:user_created renamed from :oldName to :newName folder in  Document Management.|
                         {3}:user_created toggles folder visibility for :name folder "Visible to Client" in  Document Management.|
                         {4}:user_created toggles folder visibility for :name folder "Not Visible to Client" in  Document Management.',
            'delete' => '{1}:user_created deleted :name file in  Document Management.|
                         {2}:user_created deleted :name folder in  Document Management.',
            'dowload' => ':user_created downloaded :name file  in  Document Management.'

        ],
        'create' => 'Created a new :attribute with id :id and name :name from :module',
        'update' => 'Updated :current_val to :new_val',
        'delete' => 'Deleted :current_val from :table'
    ],

    'errorMessage' => [
        'ticket' => [
            'create' => ':user_created has created ticket fail',
            'assignee' => ':user_created has assigned ticket #:id fail',
            'invite' => ':user_created has invited ticket #:id fail',
            'closed' => ':user_created has closed ticket #:id fail',
            're-open' => ':user_created has re-opened ticket #:id fail',
            'approved' => ':user_created has approved ticket #:id fail',
            'denied' => ':user_created has denied ticket #:id fail',
            'comment' => ':user_created has comment in ticket #:id fail',
            'internal' => ':user_created has internal comment in ticket #:id fail',
            'send-to-accouting' => ':user_created send to accouting ticket #:id fail',
            'auto-assign' => ':affected_user was auto assign to ticket #:id fail',

        ],
        'create' => 'Can not create a :attribute with name :name',
        'update' => 'Updated :current_val to :new_val is fail',
        'delete' => 'Can not delete :current_val from :table',
        // 'change'        => '',
        // 'create'        => '',
    ],

];
