# Inferring Binary Data

## Status

Accepted (Last updated: 2026-09-07 11:01:00 CST)

## Context

I have not needed to store binary data in a database yet.

## Decision

This library will not infer binary data types such as BLOBs or VARBINARY. Instead, this data will be inferred as literal strings.

At a later point, I may implement binary data inference if I am required to handle binary data for a project.

## Consequences

- Binary data will not be correctly typed in the inferred schema.
- Users may need to modify the output of this library to correctly handle their binary data.
