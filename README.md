# **First User Story** 

### User Story:
As an employee, I want to mention other colleagues using their usernames, so they are notified
to help us stay on the same page.

### Acceptance Criteria
Mentions must be easy to use during articles creation. The platform must help content creators
select valid usernames, notify mentioned users after posting. It should handle invalid mentions
without disrupting the publishing process.

### Main Flow (Happy path)
Given an employee is writing an article.
When they type @ followed by a username.
Then the platform should suggest matching users and allow selection.

### Alternative Flow (Happy path)
Given that multiple employees are mentioned.
When the article is posted.
Then all selected employees should be notified.

### Exception Flow (Unhappy path)
Given that an employee types an invalid username.
When they post the article.
Then the platform should ignore the invalid mention and hight lights it.

---

## V-Model

| Phase             | What I Did                                                                                                      |
| ----------------- | --------------------------------------------------------------------------------------------------------------- |
| **Requirement**   | Taken from user feedback in a questionnaire.                                                                    |
| **System Design** | Mentions are detected using a regex in the `ArticleObserver`, and users are notified via Laravel notifications. |
| **System Tests**  | I tested the full flow from writing to saving and updating articles.                                            |
| **Unit Tests**    | I tested the mention detection pattern itself to make sure it works independently.                              |

---

## Tests Breakdown

### Feature (System) Tests – `tests/Feature/MentionFeatureTest.php`

| Test                                                     | Scenario                                                                 |
| -------------------------------------------------------- | ------------------------------------------------------------------------ |
| `detects and stores mentioned users`                     | Checks that valid mentions are picked up and stored.                     |
| `removes users who are unmentioned`                      | Makes sure users are unlinked if they’re no longer mentioned.            |
| `sends a notification to the mentioned user`             | Confirms notifications are sent to newly mentioned users.                |
| `does not send a notification when modifying an article` | Prevents re-sending notifications on article edits with no new mentions. |

These tests run through the whole app flow — from creating users and articles to checking the database and notification layer.

---

### Unit Tests – `tests/Unit/MentionPatternTest.php`

| Test                                             | Scenario                                                                     |
| ------------------------------------------------ | ---------------------------------------------------------------------------- |
| `extracts usernames using the mention pattern`   | Verifies that the regex correctly finds all `@username` mentions in content. |
| `returns empty array when there are no mentions` | Confirms nothing breaks when there’s no mention at all.                      |

These are pure logic tests — no database, no Laravel services — just checking that the pattern works as expected.

---

## Screenshots
<img width="1470" alt="Screenshot 2025-06-10 at 09 49 44" src="https://github.com/user-attachments/assets/2d7648a3-5cd5-40c4-97cf-bff141411291" />

---

## Testing Overview

### What I have tested
- Detecting mentions in the article content.
- Linking mentioned users to the article.
- Notifying users when they are mentioned.
- Ignoring invalid mentions or ones removed later.

### What I didn’t cover
- Frontend behavior like autocomplete suggestions.
- Notification delivery via email or UI rendering.

---

## Why everything works correctly?

Looking back at the test plan and how I carried it out, I think the tests cover the most important parts of the feature. I tested the main and edge cases, and everything works as expected on the backend. Using factories also helped keep the test setup realistic and clean.

That said, one thing I didn’t cover well is how the feature works from the user’s point of view. For example, the platform is supposed to show suggestions when typing `@username`, but my current tests don’t check if that actually happens. This part lives more in the frontend, and isn’t something I can verify with Laravel's backend tests alone.

If I were to improve the test setup, I’d add some kind of end-to-end or browser-based testing using a tool like Cypress or Laravel Dusk. That way, I could simulate how a real user types in the mention, sees the suggestion, selects a name, and posts the article. It would also let me check if things like highlighting and UI feedback work properly. 

In conclusion: the backend logic is solid, but testing the frontend behavior is something I’d definitely add in the next version.

---

# **Second User Story** 

### User Story
As an admin, I want to define roles with specific permissions so that different employees can
access what they need.

### Acceptance Criteria
The roles management feature should allow admins to create and edit roles and sync
permissions with them. The platform must support updates over time, it should also prevent
conflicts and ensure employees can only access what they are allowed to.

###  Main Flow(Happy path)
Given that an admin goes to the roles & permissions management section.
When they create a role
Then they can assign specific permissions like read article or edit article.

### Alternative Flow(Happy path)
Given that new permissions become available over time.
When the admin goes to an existing role.
Then they can update the role by adjusting the permissions.

### Exception Flow (Unhappy path)
Given that a role includes conflicting permissions
When the admin attempts to save changes
Then the platform should display a warning message guiding the admin to fix the problem before
proceeding.

---

## V-Model

| Phase             | What I Did                                                                                   |
|------------------|-----------------------------------------------------------------------------------------------|
| **Requirement**   | Taken from user feedback in a questionnaire.                                                 |
| **System Design** | Used Laravel roles & permissions (many-to-many) with controller logic and middleware.        |
| **System Tests**  | Verified role creation, editing, deletion, and access protection.                            |
| **Unit Tests**    | Tested logic in the `HasPermissionsTrait` for syncing, role-checking, and permission access. |

---

## Test Breakdown

### Feature Tests – `tests/Feature/RoleControllerTest.php`

| Test                                              | Scenario                                                                |
|---------------------------------------------------|-------------------------------------------------------------------------|
| `admin can create role with permissions`          | Admin can create a new role with selected permissions.                  |
| `admin can update role permissions`               | Existing role permissions can be updated.                               |
| `admin can delete role`                           | Roles can be deleted properly.                                          |
| `regular user cannot access protected role routes`| Non-admin users are restricted from role management routes.             |

---

### Unit Tests – `tests/Unit/HasPermissionsTraitTest.php`

| Test                                              | Scenario                                                                |
|---------------------------------------------------|-------------------------------------------------------------------------|
| `updatePermissions syncs permissions correctly`   | Old permissions are detached and new ones are synced.                   |
| `hasPermissionTo checks direct permission`        | Verifies that a user has direct access to a permission.                 |
| `hasPermissionTo checks permission through role`  | Verifies that a user inherits permission through a role.                |
| `hasRole checks assigned roles`                   | Confirms role assignment and detection logic.                           |

---

## Screenshots
<img width="1470" alt="Screenshot 2025-06-10 at 19 12 57" src="https://github.com/user-attachments/assets/a3942455-d34f-453b-a7c5-b00c337f42b2" />

---

## Testing Overview

### What I Have Tested
- Creating, updating, and deleting roles by admins.
- Syncing permissions correctly when roles change.
- Protecting routes using permission middleware.
- Role and permission logic through unit tests.

### What I Didn’t Cover
- Concurrency issues: No tests were written for scenarios where multiple admins edit the same role at the same time.
- Audit logging: There’s no tracking or testing of who made permission changes or when — useful in enterprise environments.
- Permission dependencies: Some permissions may depend on others (e.g., `edit` might require `read`), but this logic isn’t enforced or tested yet.
- Bulk operations or API integration: The current tests focus only on web routes. API endpoint support, if needed, is not tested.

---

## Why Everything Works Correcty?

I’ve tested the most important parts of this feature from both a technical and functional point of view. Using Laravel and Pest, I wrote feature tests that simulate how an admin creates and manages roles, and unit tests that make sure the permission-checking logic works behind the scenes.

Through this layered testing:
- I can confirm that role and permission management behaves correctly.
- Users without the right access are blocked from managing sensitive resources.
- The system updates the database as expected when changes are made.

There’s still room to improve — especially when it comes to the user experience and edge cases like conflicting permissions or simultaneous edits. But for now, the backend foundation is solid. If I continue developing this, I’d focus next on adding better frontend support and writing browser-based tests using something like Laravel Dusk or Cypress to catch those finer details
