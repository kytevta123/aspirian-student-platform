# Aspirian Student Platform — Media Data Model

**Version:** 1.0
**Status:** Final Media Data Model Blueprint
**Project:** Aspirian Student Platform
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

---

# 1. Purpose

This document defines the domain-level data model for media within the Aspirian Student Platform.

The Media system provides the foundation for:

* Educational videos
* Educational audio
* Internet radio
* Live radio
* Recorded radio programs
* Podcasts
* Audio lessons
* Video lessons
* Live streams
* Educational channels
* Playlists
* Media categories
* Media collections
* Student media activity
* Media progress
* Media analytics

The model is designed to support the broader Aspirian ecosystem while remaining integrated with the academic learning platform.

---

# 2. Media Philosophy

Media should function as both:

1. **Educational content**
2. **Student engagement and discovery**

The conceptual flow is:

```text
MEDIA
  ↓
DISCOVERY
  ↓
WATCH / LISTEN
  ↓
LEARNING ACTIVITY
  ↓
LEARNING PROGRESS
```

---

# 3. Core Media Entity

The central conceptual entity is:

```text
MEDIA_ITEM
```

A Media Item represents a piece of playable or streamable media.

Examples:

```text
Video Lesson
Audio Lesson
Podcast Episode
Recorded Lecture
Radio Program
Live Stream
```

---

# 4. Media Types

Initial media types:

```text
VIDEO
AUDIO
LIVE_VIDEO
LIVE_AUDIO
RADIO_PROGRAM
PODCAST
STREAM
```

Future media types may be added without changing the overall model.

---

# 5. Media Content Sources

Media may originate from:

```text
PLATFORM
SCHOOL
TEACHER
CREATOR
PARTNER
EXTERNAL_SOURCE
USER
```

Authorization and ownership rules must be enforced separately.

---

# 6. Media Status

Possible lifecycle states:

```text
DRAFT
PROCESSING
REVIEW
SCHEDULED
PUBLISHED
LIVE
COMPLETED
ARCHIVED
CANCELLED
```

Not every media type needs every state.

---

# 7. Media Visibility

Possible visibility:

```text
PRIVATE
STUDENTS_ONLY
CLASS
SCHOOL
PLATFORM
PUBLIC
```

Visibility must always be combined with authorization.

---

# 8. Media Metadata

A Media Item may contain:

```text
Title
Description
Media Type
Duration
Thumbnail
Language
Creator
Publisher
Publication Date
Status
Visibility
```

---

# 9. Media File

A media item may reference one or more media files.

Concept:

```text
MEDIA ITEM
    ↓
MEDIA ASSET
```

A Media Asset may represent:

```text
Original File
Processed File
Streaming File
Audio Track
Video Track
Thumbnail
Caption File
Subtitle File
```

---

# 10. Media Asset

Conceptual attributes may include:

```text
id
media_item_id
asset_type
storage_reference
mime_type
file_size
duration
quality
status
```

The exact storage architecture belongs to the technical deployment design.

---

# 11. Video Data

Video media may contain:

```text
Resolution
Aspect Ratio
Duration
Frame Rate
Codec
Thumbnail
Captions
Subtitles
Audio Tracks
```

The application should not unnecessarily expose technical storage details to students.

---

# 12. Audio Data

Audio media may contain:

```text
Duration
Format
Bitrate
Language
Cover Image
Transcript
```

---

# 13. Media Quality

A Media Item may have multiple quality versions.

Example:

```text
VIDEO
 ├── 360p
 ├── 480p
 ├── 720p
 └── 1080p
```

Adaptive streaming may select the appropriate quality automatically.

---

# 14. Adaptive Streaming

Future media delivery may support:

```text
Media
 ↓
Multiple Encoded Versions
 ↓
Streaming Manifest
 ↓
Student Device
```

This should allow playback to adapt to network conditions.

---

# 15. Media Language

Media may support:

```text
English
Urdu
Roman Urdu
```

Additional languages may be added later.

---

# 16. Media Translation

A media item may have alternate language versions.

Example:

```text
Original Video
 ├── English
 ├── Urdu
 └── Roman Urdu Support
```

Language-specific assets should remain associated with the parent media item.

---

# 17. Captions

Video media should support captions where available.

Possible caption types:

```text
ORIGINAL
TRANSLATED
AUTO_GENERATED
HUMAN_VERIFIED
```

---

# 18. Subtitles

Subtitle tracks may be associated with:

```text
Media Item
Language
Subtitle Asset
```

---

# 19. Transcript

Audio and video media may have transcripts.

Concept:

```text
MEDIA
 ↓
TRANSCRIPT
 ↓
SEARCH / AI / ACCESSIBILITY
```

Transcripts may be:

```text
AUTO_GENERATED
HUMAN_CREATED
HUMAN_VERIFIED
```

---

# 20. Media Chapters

Long-form media may contain chapters.

Example:

```text
Video
 ├── Introduction
 ├── Concept 1
 ├── Concept 2
 └── Summary
```

This allows students to navigate directly to relevant sections.

---

# 21. Media Category

Media should be categorisable.

Examples:

```text
Educational
Science
Mathematics
Technology
Career
News
Entertainment
General Knowledge
```

Categories should remain configurable.

---

# 22. Media Tags

Media may contain tags for discovery.

Example:

```text
Class 9
Biology
Chapter 1
Punjab Board
Cell
```

Tags should support search and filtering.

---

# 23. Academic Mapping

Educational media may be mapped to:

```text
Board
Academic Session
Class
Group / Stream
Subject
Book
Chapter
Topic
Learning Objective
```

---

# 24. Media and Education Structure

Example:

```text
Class 9
 ↓
Biology
 ↓
Chapter 1
 ↓
Cell Structure
 ↓
Video Lesson
```

Media can therefore become part of the learning journey.

---

# 25. Media and Learning Progress

When a student consumes educational media:

```text
MEDIA
 ↓
MEDIA ACTIVITY
 ↓
LEARNING PROGRESS
```

This allows the platform to understand content engagement.

---

# 26. Media Activity

A Media Activity represents a student's interaction with media.

Examples:

```text
OPENED
STARTED
PLAYED
PAUSED
RESUMED
COMPLETED
SKIPPED
SEEKED
DOWNLOADED
```

---

# 27. Media Progress

For video/audio playback, the system may track:

```text
Current Position
Duration
Completion Percentage
Last Played At
Completed
```

Example:

```text
Video = 20 minutes
Watched = 15 minutes
Progress = 75%
```

---

# 28. Resume Playback

Students should be able to continue from their last meaningful position where supported.

```text
Student
 ↓
Media
 ↓
Last Position
 ↓
Resume
```

---

# 29. Media Completion

A media item may be marked completed according to configurable rules.

For example:

```text
Playback
 ↓
Completion Threshold
 ↓
Completed
```

The exact threshold should not be assumed to mean mastery.

---

# 30. Media Watch History

The system may maintain a student's media history.

Example:

```text
Student
 ├── Video A
 ├── Video B
 ├── Podcast C
 └── Radio Program D
```

Retention should follow platform privacy policies.

---

# 31. Media Favorites

Students may save media for later.

Possible state:

```text
SAVED
UNSAVED
```

This can support personal media libraries.

---

# 32. Media Playlist

A playlist is a collection of media items.

Example:

```text
Class 9 Biology — Chapter 1
 ├── Introduction
 ├── Cell Structure
 ├── Cell Organelles
 └── Revision
```

---

# 33. Playlist Entity

Conceptual attributes:

```text
id
title
description
owner
visibility
status
```

---

# 34. Playlist Items

A playlist may contain ordered media items.

```text
PLAYLIST
 ↓
ITEM 1
ITEM 2
ITEM 3
```

Ordering should be preserved.

---

# 35. Media Collection

A Media Collection is a broader grouping of media.

Examples:

```text
Board Exam Preparation
Science Video Library
Career Guidance
Aspirian Podcasts
```

---

# 36. Media Series

A Media Series groups related episodes.

Example:

```text
Python Programming for Students
 ├── Episode 1
 ├── Episode 2
 ├── Episode 3
 └── Episode 4
```

---

# 37. Media Episode

Episodes may belong to:

```text
Series
Season
Collection
```

This is particularly useful for podcasts and educational video series.

---

# 38. Podcast

A podcast is a structured collection of audio episodes.

```text
PODCAST
 ↓
EPISODES
 ↓
AUDIO
```

Possible metadata:

```text
Title
Description
Cover Image
Author
Category
Language
```

---

# 39. Podcast Episode

An episode may contain:

```text
Title
Description
Duration
Publication Date
Audio Asset
Transcript
Episode Number
```

---

# 40. Radio System

The Aspirian platform may include an Internet Radio service.

Concept:

```text
ASPIRIAN RADIO
      ↓
RADIO STATION
      ↓
PROGRAMS
      ↓
EPISODES / LIVE SHOWS
```

---

# 41. Radio Station

A Radio Station represents a continuous audio stream.

Conceptual data:

```text
id
name
description
station_type
stream_reference
status
language
```

---

# 42. Radio Station Types

Possible types:

```text
EDUCATIONAL
STUDENT
MUSIC
NEWS
CAREER
GENERAL
SPECIAL_EVENT
```

Actual programming and content policies should determine the final categories.

---

# 43. Radio Stream

A station may have one or more stream endpoints/assets.

```text
RADIO STATION
 ↓
STREAM
```

The actual stream infrastructure is outside this domain model.

---

# 44. Radio Schedule

Radio programs may be scheduled.

Example:

```text
08:00 → Morning Study
10:00 → Science Hour
14:00 → Career Talk
18:00 → Student Program
```

---

# 45. Radio Program

A Radio Program is a recurring or scheduled show.

Possible data:

```text
Title
Description
Host
Category
Language
Schedule
Status
```

---

# 46. Radio Episode

Recorded radio programs may be stored as media items.

```text
RADIO PROGRAM
 ↓
EPISODE
 ↓
AUDIO MEDIA
```

This allows students to listen later.

---

# 47. Live Radio

A live radio session may have:

```text
Scheduled Start
Scheduled End
Actual Start
Actual End
Stream Status
```

Possible states:

```text
SCHEDULED
LIVE
ENDED
CANCELLED
```

---

# 48. Live Video

The platform may also support live educational sessions.

Examples:

```text
Live Class
Teacher Session
Exam Preparation
Career Seminar
Student Event
```

---

# 49. Live Stream

A live stream may contain:

```text
Title
Description
Scheduled Time
Start Time
End Time
Stream Status
Audience
Academic Context
```

---

# 50. Live Event

Live media may be associated with an event.

Example:

```text
Career Guidance Session
 ↓
Live Video
 ↓
Recording
 ↓
Replay
```

---

# 51. Live-to-Recorded Conversion

After a live session ends:

```text
LIVE STREAM
     ↓
RECORDING
     ↓
MEDIA ITEM
     ↓
ON-DEMAND PLAYBACK
```

This allows valuable sessions to remain available.

---

# 52. Media Ownership

Ownership may belong to:

```text
PLATFORM
SCHOOL
TEACHER
CREATOR
PARTNER
```

Ownership should be separate from publication rights.

---

# 53. Media Licensing

Media may have rights information.

Possible fields:

```text
Rights Holder
License Type
License Expiry
Usage Restrictions
Attribution Requirement
```

---

# 54. External Media

A Media Item may reference an external provider.

Example:

```text
MEDIA
 ↓
EXTERNAL SOURCE
 ↓
EMBED / STREAM
```

External media must respect licensing and platform policies.

---

# 55. Media Embedding

Where supported, external media may be embedded rather than physically stored.

The platform should retain the source reference and relevant metadata.

---

# 56. Media Moderation

Before publication, media may pass through:

```text
Upload
 ↓
Processing
 ↓
Moderation
 ↓
Review
 ↓
Publish
```

---

# 57. Media Processing

Uploaded media may require:

```text
Transcoding
Thumbnail Generation
Audio Extraction
Caption Generation
Metadata Extraction
Streaming Preparation
```

These are technical processes, not separate academic content entities.

---

# 58. Media Processing Status

Possible states:

```text
UPLOADED
PROCESSING
READY
FAILED
REPROCESSING
```

---

# 59. Media Thumbnail

Media items may have thumbnails.

Examples:

```text
Video Thumbnail
Podcast Cover
Radio Station Artwork
Playlist Artwork
```

---

# 60. Media Artwork

Artwork may be associated with:

```text
Media Item
Podcast
Radio Station
Series
Playlist
Collection
```

---

# 61. Media Search

Students should be able to search media by:

```text
Title
Description
Subject
Topic
Class
Category
Tag
Language
Creator
```

Transcripts may eventually make spoken content searchable as well.

---

# 62. Media Recommendations

Media may be recommended based on:

```text
Learning Progress
Current Topic
Assessment Performance
Interests
Recently Viewed Content
Learning Goals
```

---

# 63. Personalized Media Recommendation

Example:

```text
Student
 ↓
Biology Weak Topic
 ↓
AI / Recommendation Engine
 ↓
Relevant Video
 ↓
Watch
 ↓
Practice
```

---

# 64. Media and AI

AI may interact with media through:

```text
Transcript Analysis
Video Summarization
Audio Summarization
Question Generation
Chapter Detection
Topic Classification
Search
Recommendations
```

---

# 65. AI Media Summary

Example:

```text
Video
 ↓
Transcript
 ↓
AI Summary
 ↓
Student
```

AI-generated summaries must be identified as AI-generated where appropriate.

---

# 66. AI Media Questions

AI may generate practice questions from approved educational media.

```text
Video
 ↓
Transcript
 ↓
AI
 ↓
Questions
 ↓
Validation
 ↓
Practice
```

---

# 67. Media Accessibility

The platform should support:

```text
Captions
Subtitles
Transcripts
Keyboard Controls
Accessible Player Controls
Readable Metadata
```

---

# 68. Media Download

Where permitted, selected media may be downloadable.

Download permissions should depend on:

```text
Media Rights
User Role
Visibility
License
Platform Policy
```

---

# 69. Offline Media

Future mobile applications may support offline playback for eligible media.

Concept:

```text
Online Media
 ↓
Authorized Download
 ↓
Local Playback
 ↓
Progress Synchronization
```

---

# 70. Media Engagement Analytics

The system may track aggregated metrics such as:

```text
Views
Unique Viewers
Starts
Completions
Average Watch Time
Average Listen Time
Completion Rate
```

---

# 71. Media Learning Analytics

Educational media may additionally track:

```text
Topic Engagement
Learning Progress After Media
Practice Activity After Media
Assessment Performance After Media
```

These metrics should be interpreted carefully.

---

# 72. Radio Analytics

Radio analytics may include:

```text
Listeners
Peak Listeners
Listening Duration
Program Popularity
Episode Plays
```

---

# 73. Media Analytics Privacy

Analytics should use the minimum required user information.

Public reporting should preferably use aggregated data.

---

# 74. Media Notifications

Students may receive notifications for:

```text
New Video
New Podcast Episode
Live Class Starting
Radio Program Starting
Recommended Content
New Educational Series
```

Notification preferences should remain configurable.

---

# 75. Media Access Control

Access may depend on:

```text
User Role
School
Class
Section
Academic Context
Subscription / Entitlement
Media Visibility
```

---

# 76. School Media

Schools may publish private educational media.

Example:

```text
School
 ↓
Class 9
 ↓
Biology
 ↓
Teacher Video
```

Only authorized students should access it.

---

# 77. Teacher Media

Teachers may upload educational media.

Possible workflow:

```text
Teacher
 ↓
Upload
 ↓
Processing
 ↓
Review
 ↓
Publish
```

---

# 78. Platform Media

Aspirian may maintain public media collections.

Examples:

```text
Exam Preparation
Career Guidance
Science Videos
Student Radio
Educational Podcasts
```

---

# 79. Media Comments

A future version may support comments or discussions.

If enabled, comments should be governed by:

```text
Moderation
User Permissions
Privacy
Safety
```

This is an optional future feature.

---

# 80. Media Ratings

A future version may support user ratings or reactions.

Possible examples:

```text
Helpful
Not Helpful
Like
Save
```

Ratings should not automatically determine educational quality.

---

# 81. Media Reporting

Users may report media for:

```text
Incorrect Information
Inappropriate Content
Copyright Concern
Technical Problem
Wrong Academic Mapping
```

---

# 82. Media Audit Trail

Important media events may be audited:

```text
Created
Uploaded
Processed
Edited
Reviewed
Published
Unpublished
Archived
Deleted
Scheduled
Started
Ended
```

---

# 83. Media Versioning

Important educational media may require versions.

Example:

```text
Video Version 1
      ↓
Updated Video Version 2
```

Historical learning activity should remain interpretable.

---

# 84. Media Content Provenance

The platform should distinguish:

```text
HUMAN_CREATED
AI_ASSISTED
AI_GENERATED
IMPORTED
EXTERNAL
LIVE_RECORDING
```

---

# 85. Media Data Integrity

The system should validate:

```text
Valid Media Type
Valid Asset
Valid Owner
Valid Visibility
Valid Academic Mapping
Valid Rights
Valid Publication State
```

---

# 86. Media Data Boundaries

This document defines the domain model for:

```text
Media Items
Media Assets
Video
Audio
Podcasts
Radio Stations
Radio Programs
Radio Episodes
Live Streams
Playlists
Collections
Series
Media Activities
Media Progress
Media Metadata
Media Analytics
```

It does not define the complete storage, CDN, transcoding or streaming infrastructure.

---

# 87. Relationship with Learning Progress

Media activity can contribute to learning progress:

```text
MEDIA
 ↓
MEDIA ACTIVITY
 ↓
LEARNING ACTIVITY
 ↓
LEARNING PROGRESS
```

However:

> Watching or listening to content alone should not automatically mean that the student has mastered the topic.

---

# 88. Relationship with Assessment

Media may support assessment preparation:

```text
MEDIA
 ↓
LEARNING
 ↓
PRACTICE
 ↓
ASSESSMENT
```

Assessment results may then drive new media recommendations.

---

# 89. Relationship with AI

AI may use media metadata and transcripts:

```text
MEDIA
 ↓
TRANSCRIPT / METADATA
 ↓
AI
 ↓
SUMMARY / QUESTIONS / RECOMMENDATION
```

---

# 90. Complete Media Architecture

```text
                         MEDIA PLATFORM
                              │
          ┌───────────────────┼───────────────────┐
          │                   │                   │
        VIDEO                AUDIO              RADIO
          │                   │                   │
     Live / VOD          Podcast / VOD       Live / Programs
          │                   │                   │
          └───────────────────┼───────────────────┘
                              ↓
                       MEDIA COLLECTIONS
                              ↓
                         STUDENT ACCESS
                              ↓
                       MEDIA ACTIVITY
                              ↓
                       LEARNING PROGRESS
                              ↓
                     AI / RECOMMENDATIONS
```

---

# 91. Complete Educational Media Flow

```text
EDUCATIONAL CONTENT
       ↓
MEDIA ITEM
       ↓
ACADEMIC MAPPING
       ↓
PUBLISH
       ↓
STUDENT WATCHES / LISTENS
       ↓
MEDIA ACTIVITY
       ↓
LEARNING PROGRESS
       ↓
PRACTICE
       ↓
ASSESSMENT
       ↓
AI / RULE-BASED RECOMMENDATION
       ↓
NEXT MEDIA
```

---

# 92. Complete Radio Flow

```text
RADIO STATION
      ↓
PROGRAM
      ↓
SCHEDULE
      ↓
LIVE BROADCAST
      ↓
LISTENER
      ↓
LISTENING ACTIVITY
      ↓
OPTIONAL RECORDING
      ↓
ON-DEMAND MEDIA
```

---

# 93. Complete Live Video Flow

```text
LIVE EVENT
      ↓
SCHEDULE
      ↓
LIVE STREAM
      ↓
STUDENT VIEWER
      ↓
LIVE ACTIVITY
      ↓
RECORDING
      ↓
ON-DEMAND MEDIA
```

---

# 94. Future Media Ecosystem

The model is designed to support future Aspirian services including:

```text
Aspirian Educational TV
Aspirian Radio
Aspirian Podcasts
Live Classes
Teacher Channels
Student Channels
Career Talks
AI Video Lessons
AI Audio Lessons
Educational News
```

---

# 95. Final Principles

The Aspirian Media Data Model must be:

> **Educational, scalable, searchable, accessible, rights-aware, privacy-conscious, learning-integrated, streaming-ready, and AI-ready.**

The media system should not exist as an isolated entertainment module.

Its educational media should connect directly with:

```text
Education Structure
       ↓
Learning Content
       ↓
Learning Progress
       ↓
Assessment
       ↓
AI Personalization
```

---

# 96. Document Status

**File:** `MEDIA_DATA_MODEL.md`
**Version:** 1.0
**Status:** Final Media Data Model Blueprint
**Academic Range:** Nursery → Class 12
**Primary Application:** `app.aspirian.pk`

This document defines the official Video, Audio, Radio and Media Data Model for the Aspirian Student Platform.
